<?php

class Connection
{
    public function __construct()
    {
        require '../vendor/autoload.php';

        $this->credentials = "credentials.json";
        $this->client = $this->create_client();
    }

    public function get_client()
    {
        return $this->client;
    }

    public function get_credentials()
    {
        return $this->credentials;
    }

    public function is_connected()
    {
        return $this->is_connected;
    }

    public function get_unauthenticated_data()
    {
        $authUrl = $this->client->createAuthUrl();
        return $authUrl;
    }

    public function credentials_in_browser()
    {
        if (isset($_GET['code']))
            if ($_GET['code'])
                return true;

        return false;
    }

    public function create_client()
    {

        session_start();
        $client = new Google_Client();
        $client->setApplicationName('Gmail API PHP Quickstart');
        $client->setScopes(Google_Service_Gmail::GMAIL_READONLY);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('online');
        $client->setPrompt('select_account consent');

        if (isset($_SESSION['token']) and !empty($_SESSION['token'])) {
            $accessToken = json_decode($_SESSION['token'], true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken())
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            elseif ($this->credentials_in_browser()) {
                $authCode = $_GET['code'];

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken))
                    throw new Exception(join(', ', $accessToken));
            } else {
                $this->is_connected = false;
                return $client;
            }

            if ((!isset($_SESSION['token'])) or (empty($_SESSION['token'])))
                $_SESSION['token'] = json_encode($client->getAccessToken());
        }/* else
            echo "<p>Not Expired</p><br/>\n";*/

        $this->is_connected = true;
        return $client;
    }
}

class GmailAPI
{
    private $client;
    private $service;
    private $messageIDs;
    private $userID;
    private $labelID;
    private $maxResults;

    public function __construct($client, $labelID = 'INBOX', $maxResults = 100)
    {
        $this->client = $client;
        $this->userID = "me";
        $this->labelID = $labelID;
        $this->maxResults = $maxResults;
        $this->service = new Google_Service_Gmail($client);
        $this->messageIDs = $this->fetchMessageIDs();

    }

    public function getMessagesIDs()
    {
        return $this->messageIDs;
    }

    public function fetchMessageIDs()
    {
        if (!isset($_SESSION['ids'])) {
            $ids = array();

            $messageList = $this->service->users_messages->listUsersMessages($this->userID, ['labelIds' => $this->labelID, 'maxResults' => $this->maxResults]);

            while ($messageList->getMessages() != null) {
                foreach ($messageList->getMessages() as $message)
                    array_push($ids, $message->id);

                if ($messageList->getNextPageToken() != null) {
                    $pageToken = $messageList->getNextPageToken();
                    $messageList = $this->service->users_messages->listUsersMessages($this->userID, ['pageToken' => $pageToken, 'maxResults' => $this->maxResults, 'labelIds' => $this->labelID]);
                } else break;
            }

            $_SESSION['ids'] = $ids;
            return $ids;
        }
    }

    private function getMessageHeader($message)
    {
        $result = array();
        $headers = $message->payload->headers;

        foreach ($headers as $header) {
            if ($header->name == 'Subject')
                $result['Subject'] = $header->value;
            else if ($header->name == 'From')
                $result['Sender'] =
                    substr($header->value, 0, strpos($header->value, '<') - 1);
            else if ($header->name == 'Return-Path')
                $result['Address'] =
                    substr($header->value, 1, strlen($header->value) - 2);
        }

        return $result;
    }

    private function decodeBody($encoded)
    {
        $rawData = $encoded;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if (!$decodedMessage) {
            $decodedMessage = FALSE;
        }
        return $decodedMessage;
    }

    private function getMessageBody($message)
    {
        $payload = $message->getPayload();

        $body = $payload->getBody();
        $FOUND_BODY = $this->decodeBody($body['data']);

        if (!$FOUND_BODY) {
            $parts = $payload->getParts();
            foreach ($parts as $part) {
                if ($part['body'] && $part['mimeType'] == 'text/html') {
                    $FOUND_BODY = $this->decodeBody($part['body']->data);
                    break;
                }
            }
        }
        if (!$FOUND_BODY) {
            foreach ($parts as $part) {
                if ($part['parts'] && !$FOUND_BODY) {
                    foreach ($part['parts'] as $p) {
                        if ($p['mimeType'] === 'text/html' && $p['body']) {
                            $FOUND_BODY = $this->decodeBody($p['body']->data);
                            break;
                        }
                    }
                }
                if ($FOUND_BODY) {
                    break;
                }
            }
        }
        return array('Body' => $FOUND_BODY);
    }

    private function getMessageDate($message)
    {
        error_reporting(0);

        $date = date_create();
        $internalDate = substr($message->internalDate, 0, strlen($message->internalDate) - 3);

        date_time_set($date, $internalDate);

        return array('Date' => date("d-m-y h:i:s", $internalDate));
    }

    public function getMessageByID($messageID)
    {
        $message = $this->service->users_messages->get($this->userID, $messageID);

        $messageHeader = $this->getMessageHeader($message);
        $messageBody = $this->getMessageBody($message);
        $messageDate = $this->getMessageDate($message);

        return array_merge($messageHeader, $messageBody, $messageDate);
    }

}

$conn = new Connection();
if ($conn->is_connected()) {
    $gmailAPI = new GmailAPI($conn->get_client());

    include "main.php";
} else
    header('Location: ' . $conn->get_unauthenticated_data());

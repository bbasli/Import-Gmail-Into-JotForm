<?php

class Connection  {

    public function __construct()  {
    
        $this->credentials = "credentials.json";
        $this->client = $this->create_client();
    
    }

    public function get_client()  {
       return $this->client;
    }

    public function get_credentials()  {
        return $this->credentials;
    }

    public function is_connected()  {
        return $this->is_connected;
    }

    public function get_unauthenticated_data()  {
        // Request authorization from the user.
        $authUrl = $this->client->createAuthUrl();
        return $authUrl;
    }

    public function credentials_in_browser()  {
        if(isset($_GET['code']))
            if ($_GET['code'])
                return true;
                
        return false;
    }

    public function create_client()  {

        session_start();
        $client = new Google_Client();
        $client->setApplicationName('Gmail API PHP Quickstart');
        $client->setScopes(Google_Service_Gmail::GMAIL_READONLY);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
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
                
            }
            else  {
                
                $this->is_connected = false;
                return $client;
            }

            if ( (!isset($_SESSION['token'])) or (empty($_SESSION['token'])) )
                $_SESSION['token'] = json_encode($client->getAccessToken());

        }
        else
            echo "<p>Not Expired</p><br/>\n";

        $this->is_connected = true;
        return $client;
    }

}

?>
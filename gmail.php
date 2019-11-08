<?php

class Gmail  {

    public function __construct($client)  {
        $this->client = $client;
    }
    
    function listMessages() {
      ini_set('memory_limit', '1024M');
      $sender_address = $sender_name = $msg_subject = $msg_content = $msg_date = "";
      $result = array();
      $service = new Google_Service_Gmail($this->client);
      $userId = "me";
      $pageToken = NULL;
      $messages = array();
      $opt_param = array();
      do {
        try {
          if ($pageToken) {
            $opt_param['pageToken'] = $pageToken;
          }
          $messagesResponse = $service->users_messages->listUsersMessages($userId, ['labelIds' => 'INBOX']);
          if ($messagesResponse->getMessages()) {
            $messages = array_merge($messages, $messagesResponse->getMessages());
            $pageToken = $messagesResponse->getNextPageToken();
          }
        } catch (Exception $e) {
          print 'An error occurred: ' . $e->getMessage();
        }
      } while ($pageToken);
    
      foreach ($messages as $message) {

        $msg = $service->users_messages->get($userId, $message->getId());
            
            // to get message CONTENT
            if(isset($msg->payload->parts[1]->body->data)) {
                $rawData = $msg->payload->parts[1]->body->data;
                $sanitizedData = strtr($rawData, "-_", "+/");
                $msg_content = base64_decode($sanitizedData);
                if (!$msg_content)
                    $msg_content = FALSE;
                
            }

            // to get message DATE
            $date = date_create();
            $internal_date = substr($msg->internalDate, 0, strlen($msg->internalDate)-3);
            date_timestamp_set($date, $internal_date);
            $msg_date = date_format($date, "d-m-Y H:i:s");

            $headers = $msg->payload->headers;
            foreach ($headers as $header)  {
                
                // to get message SUBJECT
                if ($header->name === "Subject")
                    $msg_subject = $header->value;
                    
                // to get sender NAME
                elseif ($header->name === "From") {
                    $sender_name = $header->value;
                    $sender_name = substr($sender_name, 0, strpos($sender_name, "<")-1);
                }
                    
                // to get sender ADDRESS
                elseif ($header->name === "Return-Path")
                    $sender_address = substr($header->value, 1, strlen($header->value)-2);
                
                else
                    continue;
            }
      
        if (strlen($sender_address)>0 and strlen($sender_name)>0 and strlen($msg_subject)>0 and strlen($msg_date)>0 and strlen($msg_content)>0 )  {
                //echo "<pre>" . $sender_address . "  -  " . $msg_subject . "  -  " . $msg_date . "</pre>";
                //echo "<pre>" . $sender_name . "  !!!!!!!  " . $msg_content . "</pre>";
                //echo $msg_content ."<br/> !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! <br/>";
                //return $msg_content;
                //die();
                $sub = array($sender_address, $sender_name, $msg_subject, $msg_content, $msg_date);
                array_push($result, $sub);
        }
      }
        return $result;
    }
    
}




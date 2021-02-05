<?php

if (isset($_SESSION['searchType']) and isset($_SESSION['searchedText'])) {
    $searchedText = $_SESSION['searchedText'];
    $searchType = $_SESSION['searchType'];
}

$isValidEmail = false;

$upperBound = 100;
for ($i = 0; $i < $upperBound && $i < count($msg_ids); $i++) {

    $message = $gmailAPI->getMessageByID($msg_ids[$i]);

    /*    if (!empty($search))
            if (gettype(isAvailable($message, $in, $search)) !== "integer") {
                continue;
            }*/

    $submission = array(
        $email_id => $message['Address'],
        $name_id => $message['Sender'],
        $content_id => $message['Body'],
        $subject_id => $message['Subject'],
        $date_id => $message['Date']
    );

    if (gettype(stripos($message['Sender'], "Google")) != "integer") {
        if (isset($searchedText) and isset($searchType)) {
            echo $searchType . "<br/>";
            echo $searchedText . "<br/>";
            switch ($searchType) {
                case "subject":
                    $isValidEmail = stripos($message['Subject'], $searchedText) !== false;
                    break;
                case "address":
                    $isValidEmail = stripos($message['Address'], $searchedText) !== false;
                    break;
                case "name":
                    $isValidEmail = stripos($message['Sender'], $searchedText) !== false;
                    break;
            }
            if ($isValidEmail)
                $response = ($jotformAPI->createFormSubmission($valid_form, $submission));
        } else
            $response = ($jotformAPI->createFormSubmission($valid_form, $submission));

    }
}
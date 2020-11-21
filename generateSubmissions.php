<?php
foreach ($messageIDs as $id) {
    $message = $gmailAPI->getMessageByID($id);

    if (!empty($search))
        if (gettype(isAvailable($message, $in, $search)) !== "integer") {
            continue;
        }

    $submission = array(
        $email_id => $message['Address'],
        $name_id => $message['Sender'],
        $content_id => $message['Body'],
        $subject_id => $message['Subject'],
        $date_id => $message['Date']
    );

    $response = ($jotformAPI->createFormSubmission($valid_form, $submission));
    if($response['URL'] !== null)
        header('Location: successful.php');
}
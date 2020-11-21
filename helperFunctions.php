<?php

function createQuestion($api, $formID, $text_name, $type)
{
    if ($type === "Subject") {
        $question = array(
            'name' => 'name',
            'order' => 2,
            'size' => '20',
            'text' => $text_name,
            'type' => 'control_textbox',
        );
    } elseif ($type === "Address") {
        $question = array(
            'confirmationHint' => 'example@example.com',
            'confirmationSublabel' => 'Confirm Email',
            'name' => 'email',
            'order' => 2,
            'size' => '30',
            'subLabel' => 'example@example.com',
            'text' => $text_name,
            'type' => 'control_email',
            'validation' => 'Email',
        );
    } elseif ($type === "Name") {
        $question = array(
            'name' => 'name',
            'order' => 2,
            'size' => '20',
            'text' => $text_name,
            'type' => 'control_textbox',
        );
    } elseif ($type === "Content") {
        $question = array(
            'cols' => '40',
            'name' => 'content',
            'order' => 2,
            'rows' => '6',
            'text' => $text_name,
            'type' => 'control_textarea',
            'wysiwyg' => 'Disable'
        );
    } else {
        $question = array(
            'dateSeparator' => '-',
            'days' => 'Sunday|Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday',
            'format' => 'ddmmyyyy',
            'limitDate' => '{"days":{"monday":"true","tuesday":"true","wednesday":"true","thursday":"true","friday":"true","saturday":"true","sunday":"true"},"future":"true","past":"true","custom":"false","ranges":"false","start":"","end":""}',
            'liteMode' => 'Yes',
            'minAge' => '13',
            'months' => 'January|February|March|April|May|June|July|August|September|October|November|December',
            'name' => 'date8',
            'onlyFuture' => 'No',
            'order' => 2,
            'startWeekOn' => 'Sunday',
            'step' => '10',
            'sublabels' => array(
                'day' => 'Day',
                'month' => 'Month',
                'year' => 'Year',
                'last' => 'Last Name',
                'hour' => 'Hour',
                'minutes' => 'Minutes',
                'litemode' => 'Date',
            ),
            'text' => $text_name,
            'timeFormat' => 'AM/PM',
            'today' => 'Today',
            'type' => 'control_datetime',
            'validateLiteDate' => 'Yes'
        );
    }

    $api->createFormQuestion($formID, $question);
}

function getQuestionId($api, $formID, $text_name, $type)
{
    $questions = $api->getFormQuestions($formID);
    foreach ($questions as $question) {
        if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
            if ($question['type'] === $type) {
                if ($question['text'] === $text_name) {
                    return $question['qid'];
                }
            }
    }

    return -1;
}

function isAvailable($message, $part, $target)
{
    switch ($part) {
        case '1':
            return stripos($message['Sender'], $target);
        case '2':
            return stripos($message['Address'], $target);
        case '3':
            if(stripos($message['Subject'], "Security alert") !== FALSE)
                return false;
            return stripos($message['Subject'], $target);
        case '4':
            return stripos($message['Body'], $target);
        default:
            return false;
    }
}


<?php
$subject_id = $_POST['Subject'];
$email_id = $_POST['Address'];
$name_id = $_POST['Name'];
$content_id = $_POST['Content'];
$date_id = $_POST['Date'];
$search = $_POST['search'];
$in = $_POST['search-in'];

if (!is_numeric($subject_id)) {
    createQuestion($jotformAPI, $valid_form, $subject_id, "Subject");
    $subject_id = getQuestionId($jotformAPI, $valid_form, $subject_id, "control_textbox");
}
if (!is_numeric($email_id)) {
    createQuestion($jotformAPI, $valid_form, $email_id, "Address");
    $email_id = getQuestionId($jotformAPI, $valid_form, $email_id, "control_email");
}
if (!is_numeric($name_id)) {
    createQuestion($jotformAPI, $valid_form, $name_id, "Name");
    $name_id = getQuestionId($jotformAPI, $valid_form, $name_id, "control_textbox");
}
if (!is_numeric($content_id)) {
    createQuestion($jotformAPI, $valid_form, $content_id, "Content");
    $content_id = getQuestionId($jotformAPI, $valid_form, $content_id, "control_textarea");
}
if (!is_numeric($date_id)) {
    createQuestion($jotformAPI, $valid_form, $date_id, "Date");
    $date_id = getQuestionId($jotformAPI, $valid_form, $date_id, "control_datetime");
}

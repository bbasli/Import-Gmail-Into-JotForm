<?php
require_once 'JotForm.php';
require_once 'helperFunctions.php';

function getQuestionFields($api, $formID)
{
    $questions = $api->getFormQuestions($formID);

    $text_boxes = 0;
    $email = 0;
    $text_area = 0;
    $datetime = 0;
    foreach ($questions as $question) {
        //echo $question['type']."<br/>";
        if (isset($question['type'])) {
            //echo $question['type'] . "<br/>";
            if ($question['type'] === "control_textbox")
                $text_boxes++;
            else if ($question['type'] === "control_email")
                $email++;
            else if ($question['type'] === "control_textarea")
                $text_area++;
            else if ($question['type'] === "control_datetime")
                $datetime++;
        }
    }

    if ($text_boxes > 1 or $email > 0 or $text_area > 0 or $datetime > 0)
        return array($text_boxes, $email, $text_area, $datetime);
    else return array();
}

function isValidate($fields)
{
    if ($fields)
        if ($fields[0] > 1 and $fields[1] > 0 and $fields[2] > 0 and $fields[3] > 0)
            return true;
    return false;
}

function getMissingFields($fields)
{
    $missings = array();
    if (count($fields) > 0) {
        if ($fields[0] < 2)
            array_push($missings, array('textbox' => (2 - $fields[0])));
        if ($fields[1] < 1)
            array_push($missings, array('email' => 1));
        if ($fields[2] < 1)
            array_push($missings, array('textarea' => 1));
        if ($fields[3] < 1)
            array_push($missings, array('datetime' => 1));
    }
    return $missings;
}

function validateForm($api, $fields, $formID)
{
    $missings = (getMissingFields($fields));
    foreach ($missings as $missing) {
        foreach ($missing as $key => $value)
            if ($key === "textbox")
                if ($value == "2") {
                    createQuestion($api, $formID, 'Automated textbox', 'Subject');
                    createQuestion($api, $formID, 'Automated textbox', 'Name');
                } else
                    createQuestion($api, $formID, 'Automated textbox', 'Subject');
            else if ($key === "email")
                createQuestion($api, $formID, 'Automated email', 'Address');
            else if ($key === "textarea")
                createQuestion($api, $formID, 'Automated textarea', 'Content');
            else if ($key === "datetime")
                createQuestion($api, $formID, 'Automated datetime', 'Date');
    }
}

if (isset($_COOKIE['apiKey']) and (isset($_COOKIE['formID']) or isset($_POST['formID']))) {

    if (isset($_COOKIE['formID']))
        $formID = $_COOKIE['formID'];
    if (isset($_POST['formID'])) {
        $formID = $_POST['formID'];
        $_COOKIE['formID'] = $formID;
    }

    $api = new JotForm($_COOKIE['apiKey']);

    $fields = getQuestionFields($api, $formID);

    if (isValidate($fields)) {
        $formHtml = file_get_contents("https://form.jotform.com/" . $_COOKIE['formID']);
        file_put_contents("form.html", $formHtml);
        include_once "mapping.php";
    } else {
        $forms = array();
        include_once "header.html";

        if (isset($_POST['select-valid'])) {
            foreach ($api->getForms() as $form) {
                $f = getQuestionFields($api, $form['id']);
                if (isValidate($f))
                    array_push($forms, array('id' => $form['id'], 'title' => $form['title']));
            }

            echo "<form class='select-valid-form' method='post'>";
            echo "<h2>Select Valid Form From List</h2>";
            echo "<select name='formID'>";
            foreach ($forms as $form)
                echo "<option value='" . $form['id'] . "'>" . $form['title'] . "</option>";
            echo "</select>";
            echo "<input type='submit' class='btn-warning' value='SELECT'/>";
            echo "</form>";

        } else if (isset($_POST['validate'])) {
            if ($_POST['validate']) {
                validateForm($api, $fields, $formID);
                header("Location: formValidator.php");
            }
        } else {
            ?>
            <div class="invalid-error">
                <h2>OOPSSSS !!! :(</h2>
                <p>Your selected form is invalid.
                    If you want, you can change your form or we can validate it for you.</p>
                <form method="post">
                    <input type="submit" class="btn-warning" name="select-valid" value="SELECT VALID FORM"/>
                    <input type="submit" class="btn-warning" name="validate" value="VALIDATE FORM"/>
                </form>
            </div>

            <?php
            include_once "footer.html";
        }
    }
}

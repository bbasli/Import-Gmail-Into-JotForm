<?php
for ($i = 0; $i < 5; $i++) {
    echo "<div class='col-lg-2'>";
    echo $fields[$i] . "<br>";
    echo "<select id='box_" . $i . "'class='custom-select' style='width:75%;' name=" . substr($fields[$i], strripos($fields[$i], " ")) . "><br>";
    echo "<option value=-1 selected> Select Field </option><br>";
    foreach ($questions as $question) {
        if ($i === 1) {
            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
                if ($question['type'] === "control_email")
                    echo "<option value=" . $question['qid'] . ">" . $question['text'] . "</option><br>";
        } elseif ($i === 3) {
            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
                if ($question['type'] === "control_textarea")
                    echo "<option value=" . $question['qid'] . ">" . $question['text'] . "</option><br>";
        } elseif ($i === 4) {
            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
                if ($question['type'] === "control_datetime")
                    echo "<option value=" . $question['qid'] . ">" . $question['text'] . "</option>";
        } else {
            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
                if ($question['type'] === "control_textbox")
                    echo "<option value=" . $question['qid'] . ">" . $question['text'] . "</option><br>";
        }
    }
    echo "<option value=0> Add a new question </option><br>";
    echo "</select>";
    echo "<input type='text' id = 'input" . $i . "'name='input' placeholder='   Add new field' style='display:none;'/></div>";
}
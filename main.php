<?php

require_once 'JotForm.php';
include "header.html";

$error_msg = $subject_id = $email_id = $name_id = $content_id = $date_id = "";

if (isset($_COOKIE['formID']) and isset($_COOKIE['apiKey']) and isset($_SESSION['ids'])) {

    $apiKey = $_COOKIE['apiKey'];
    $jotformAPI = new JotForm($apiKey);

    $valid_form = $_COOKIE['formID'];
    $messageIDs = $_SESSION['ids'];
    $form_title = $jotformAPI->getForm($valid_form)['title'];$questions = $jotformAPI->getFormQuestions($valid_form);

    $fields = [];
    $fields[0] = "Choose field for Email Subject";
    $fields[1] = "Choose field for Email Address";
    $fields[2] = "Choose field for Sender Name";
    $fields[3] = "Choose field for Email Content";
    $fields[4] = "Choose field for Email Date";

    include "container.html";
    include 'getMappingFields.php';
    include "helperFunctions.php";

    if (isset($_POST['submit'])) {

        error_reporting(0);
        include "checkMappingFields.php";

        if ($email_id === "-1" or $name_id === "-1" or $content_id === "-1" or $subject_id === "-1" or $date_id === "-1") {
            $error_msg = "You have to select all neccessary field!";
        }
        else {
            include "generateSubmissions.php";
        }
    }
}
?>
<div class="col-lg-1"></div>
</div>
<div class="row" id="search">
    <div class="col-lg-1"></div>
    <div class="col-lg-5">
        <input class="form-control amber-border" type="text" placeholder="Search" aria-label="Search"
               style="height: 35px;" name="search">
    </div>
    <div class="col-lg-1" style="padding-top: 0.5%; padding-left: 3%;">
        IN
    </div>
    <div class="col-lg-3">
        <select class="custom-select" id="search-in" style="height: 35px;" name="search-in">
            <option value="1" selected>Sender Name</option>
            <option value="2">Email Address</option>
            <option value="3">Subject</option>
            <option value="4">Content</option>
        </select>
    </div>
    <div class="col-lg-2" style="border:none;"></div>
</div>
<button type='submit' name="submit" class='btn btn-warning btn-lg' id="submit"> Integrate</button>
</form>
<span id="error" align="center"> <?php echo $error_msg; ?></span>
</div>

<?php include "footer.html" ?>


</div>
<script type="text/javascript" src="reform.js"></script>
</body>
</html>
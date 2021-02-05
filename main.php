<?php

require_once 'JotForm.php';
include "header.html";

if ((isset($_COOKIE['formID']) or isset($_SESSION['formID'])) and isset($_COOKIE['apiKey'])) {

    $subject_id = $_COOKIE['subjectId'];
    $name_id = $_COOKIE['nameId'];
    $email_id = $_COOKIE['addressId'];
    $content_id = $_COOKIE['contentId'];
    $date_id = $_COOKIE['dateId'];

    $apiKey = $_COOKIE['apiKey'];
    $jotformAPI = new JotForm($apiKey);

    $valid_form = "";
    if (isset($_COOKIE['formID']))
        $valid_form = $_COOKIE['formID'];

    $msg_ids = $gmailAPI->getMessagesIDs();

    include "generateSubmissions.php";
    header('Location: successful.php');
}
?>
</div>

<?php include "footer.html" ?>


</div>
<script type="text/javascript" src="reform.js"></script>
</body>
</html>
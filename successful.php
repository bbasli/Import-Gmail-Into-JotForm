<?php
include "header.html";
session_start();

if (isset($_COOKIE['formID'])) {
    $formID = $_COOKIE['formID'];
    $editUrl = "https://www.jotform.com/build/" . $formID;
    $submissionUrl = "https://www.jotform.com/submissions/" . $formID;
    $sheetUrl = "https://www.jotform.com/sheets/" . $formID;
    ?>
    <div class="jumbotron jump2" id="jump">
        <img src="images/check-circle.png" id="check-circle"><br/>
        <span>Import Completed Successfully</span><br/><br/>

        <a class="button" href="<?php echo $editUrl; ?>" target="_blank" class="button"> To Edit Your Form </a> <br/>
        <a class="button" href="<?php echo $submissionUrl; ?>" target="_blank" class="button">
            To See Your Submission
        </a> <br/>
        <a class="button" href="<?php echo $sheetUrl; ?>" target="_blank" class="button">
            To See Your Submission on Tables
        </a> <br/>
        <a class="button" href="index.php" target="_blank" class="button"> To Go Home Page </a>
    </div>
    <?php
}
else {
    ?>
    <div class="jumbotron" id="jump">
        <img src="images/cancel-icon.png" id="check-circle"><br/><br/>
        <span style="color:red;">Import Can't Be Completed</span><br/><br/>
        <a class="button" href="index.php" target="_blank" class="button"> To Go Home Page </a>
    </div>

    <?php
}
include "footer.html";
?>
</div>
</body>
</html>
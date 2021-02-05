<?php include "header.html" ?>

<div class="jumbotron job" id="jump" style="margin-top: 10rem;">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="display-5">Gmail Import App</h1>
            <p class="lead">
                In a few steps, you can easily import your gmails into JotForm and you can handle your emails using
                submissions and JotForm Tables.
            </p>
            <hr class="my-4">
            <p></p>
            <button class="btn btn-warning btn-lg mt-5" onclick="loginFunction(1)">SELECT FORM</button>
            <button class="btn btn-warning btn-lg mt-5" onclick="loginFunction(2)">CREATE FORM</button>
        </div>
        <div class="col-lg-6">
            <img src="images/gmail-logo.png" id="visual">
        </div>
    </div>
</div>

</div>
<?php include "footer.html" ?>

<script type="text/javascript">
    window.JF = JF;
    <?php
    session_start();
    if (isset($_COOKIE['apiKey'])) {
        if ($_COOKIE['apiKey'])
            echo "var apiKey = '" . $_COOKIE['apiKey'] . "';";
    } else {
        echo "var apiKey = '';";
    }
    ?>

    if (apiKey.length > 0) {
        JF.initialize({
            'apiKey': apiKey
        });
    } else {
        JF.initialize({
            'accessType': 'full'
        });
    }

    function loginFunction(choice) {
        window.JF.login(function success() {
                apiKey = window.JF.getAPIKey();
                document.cookie = "apiKey=" + apiKey;
                if (choice == "1")
                    formPicker();
                else
                    top.location = "createForm.php";
            },
            function error() {
                window.alert("Could not authorize user");
            }
        );
    }

    function formPicker() {
        window.JF.FormPicker({
            multiSelect: false,
            infinite_scroll: true,
            search: true,
            onSelect: function (r) {
                var selectedIds = [];
                for (var i = 0; i < r.length; i++)
                    selectedIds.push(r[i].id);
                document.cookie = "formID=" + selectedIds;
                top.location = "formValidator.php"
            }
        });
    }

</script>
</body>
</html>
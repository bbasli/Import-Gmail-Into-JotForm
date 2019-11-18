<!DOCTYPE html>
<html>
<head>
	<title> Gmail APP </title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="index.css">
	
	<script src="https://js.jotform.com/JotForm.js"></script>
  	<script src='https://js.jotform.com/FormPicker.min.js'></script>
</head>
<body>
	<div class="full-container">
	
		<nav class="navbar navbar-light bg-dark" id="my-navbar">
		  <a class="navbar-brand" href="https://bgrbasli.com" id="linkk">
		    <img src="images/logo.png" width="30" height="30" alt="">
		    JotForm
		  </a>
		</nav>

		<div class="jumbotron" id="jump" style="margin-top: 10rem;">
			<div class="row">
			    <div class="col-lg-6">
			      <h1 class="display-5">Gmail Import App</h1>
				  <p class="lead">
				  	In a few steps, you can easily import your gmails into JotForm and you can handle your emails using submissions and JotForm Sheets.
				  </p>
				  <hr class="my-4">
				  <p></p>
				  <button class="btn btn-warning btn-lg mt-5" onclick="loginFunction()">SELECT FORM</button>
			    </div>
			    <div class="col-lg-6">
			      	<img src="images/gmail-logo.png" id="visual">
			    </div>
			</div>
		</div>
		<footer class="footer" id="footer">
	        <div class="footer-copyright text-center py-3">Powered by
	    		<a class="btn" target="_blank" id="link1" href="https://www.jotform.com/"> JotForm</a>
	    		|
	    		<a class="btn" target="_blank" id="link2" href="https://www.jotform.com/apps/"> JotForm Apps</a>
	  		</div>
	    </footer>
	</div>


	<script type="text/javascript">
	    
	    window.JF = JF;
	    <?php
	    session_start();
	    unset($_SESSION['result']);

	    if (isset($_SESSION['apiKey'])) {
	      echo "var apiKey = '". $_SESSION['apiKey'] ."';";
	    } else {
	      echo "var apiKey = '';";
	    }
	    ?>

	    if (apiKey.length > 0) {
	      JF.initialize({'apiKey':apiKey});
	    }else {
	      JF.initialize({'accessType': 'full'});
	    }

	    function loginFunction() {
	          window.JF.login(function success(){
	                    apiKey = window.JF.getAPIKey();
	                    formPicker();
	                },
	                function error(){
	                    window.alert("Could not authorize user");
	                }
	              );
	    }

	    function formPicker()  {
	      window.JF.FormPicker({
	        multiSelect: false,
	            infinite_scroll: true,
	            search: true,
	            onSelect: function(r) {
	                var selectedIds = [];
	                for(var i=0; i<r.length; i++)
	                    selectedIds.push(r[i].id);
	                
	                const xhr = new XMLHttpRequest();
	                xhr.open("POST", "passer.php", true);
	                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	                xhr.send("apiKey="+apiKey+"&formID="+selectedIds);
	                top.location = "authentication.php";
	            }
	        });
	    }

  </script>
</body>
</html>
<html>
<head>
    
	<title> Gmail APP </title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="successful.css">

</head>
<body>

	<div class="full-container">
	
		<nav class="navbar navbar-light bg-dark" id="my-navbar">
		  <a class="navbar-brand" href="https://bgrbasli.com" id="linkk">
		    <img src="images/logo.png" alt="JotForm" id="brand">
		    JotForm
		  </a>
		</nav>

		<?php 
			session_start();

			if (isset($_SESSION['formID'])) {
			
    			$formID = $_SESSION['formID'];
    			$editUrl = "https://www.jotform.com/build/" . $formID;
    			$submissionUrl = "https://www.jotform.com/submissions/" . $formID;
    			$sheetUrl = "https://www.jotform.com/sheets/" . $formID;
		?>

		<div class="jumbotron" id="jump">
			<img src="images/check-circle.png" id="check-circle"><br />

			<span>Import Completed Successfully</span><br /><br />

			<a class="button" href="<?php echo $editUrl;?>" target="_blank" class="button"> To Edit Your Form </a> <br />
			<a class="button" href="<?php echo $submissionUrl;?>" target="_blank" class="button"> To See Your Submission </a> <br />
			<a class="button" href="<?php echo $sheetUrl;?>" target="_blank" class="button"> To See Your Submission in Sheets </a> <br />
			<a class="button" href="index.php" target="_blank" class="button"> To Go Home Page </a>
		</div>

		<?php 

			}else {

		?>

		<div class="jumbotron" id="jump">
			<img src="images/cancel-icon.png" id="check-circle"><br /><br />

			<span style="color:red;">Import Can't Be Completed</span><br /><br />

			<a class="button" href="index.php" target="_blank" class="button"> To Go Home Page </a>
		</div>

		<?php 
			}
		?>
		<footer class="footer" id="footer">
	        <div class="footer-copyright text-center py-3">Powered by
	    		<a class="btn" id="link1" href="https://www.jotform.com/"> JotForm</a>
	    		|
	    		<a class="btn" id="link2" href="https://www.jotform.com/apps/"> JotForm Apps</a>
	  		</div>
	    </footer>

	</div>


	
</body>
</html>
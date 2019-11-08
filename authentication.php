
<html>
<head>
	<title> Gmail APP </title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="auth.css">

</head>
<body>

	<?php 

		include "getMails.php";
			    
		$mails = new getMails();
		$link = $mails->setup();

	?>


	<div class="full-container">
	<!-- Just an image -->
		<nav class="navbar navbar-light bg-dark" id="my-navbar">
		  <a class="navbar-brand" target="_blank" href="https://bgrbasli.com" id="linkk">
		    <img src="images/logo.png" alt="JotForm" id="brand">
		    JotForm
		  </a>
		</nav>

		<div class="container" id="auth-link">
			<a id='link' href='<?php echo $link; ?>' style='color:white'> 
				<img src="images/google-sign.png" id="sign-in" style="height: 75px;">
			     Authenticate Your Gmail Account 
			 </a>
		</div>

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
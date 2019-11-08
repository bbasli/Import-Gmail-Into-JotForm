<!DOCTYPE html>
<html>
<head>
	<title> Gmail APP </title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="createSub.css">
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	
</head>
<body>
	
	<div class="full-container">

		<nav class="navbar navbar-light bg-dark" id="my-navbar">
		  <a class="navbar-brand" href="https://bgrbasli.com" id="bar">
		    <img src="images/logo.png" width="30" height="30" alt="">  JotForm
		  </a>
		</nav>

		<?php 

		    include 'JotForm.php';
		    session_start();
		    $error_msg = $subject_id = $email_id = $name_id = $content_id = $date_id = "";

		    if (isset($_SESSION['formID']) and isset($_SESSION['apiKey'])) {
        
		        $valid_form = $_SESSION['formID'];
		        $apiKey = $_SESSION['apiKey'];
		        //echo $valid_form . "  ----  " . $apiKey;
		        $jotformAPI = new JotForm($apiKey);
		        $form_title = $jotformAPI->getForm($valid_form)['title'];
		        
		        $questions = $jotformAPI->getFormQuestions($valid_form);

		        $fields = [];
		        $fields[0] = "Choose field for Email Subject";
		        $fields[1] = "Choose field for Email Address";
		        $fields[2] = "Choose field for Email Name";
		        $fields[3] = "Choose field for Email Content";
		        $fields[4] = "Choose field for Email Date";
		        //print_r($questions);

		        ?>

		<div id="mycontainer">
			<h2 align='center' style='margin-top:2rem; margin-bottom:1.25rem;'>IMPORT GMAIL</h2>
			<div class="container">
				<p> In this app can get 5 major part of email. These are 
				email subject, 
				email content, 
				email retrieved date, 
				sender email address 
				and sender name. For submitting these data, you have to choose form's field for each part. 
				If there is any suitable form field, you can create an appropriate field instantly by clicking "Add new question". </p>
			</div>
				
			<form action="" method="post" id="info">
                <h4 class="display-5" align="center"> MAPPING </h4>
                <div class="row" id='selects'>
                	<div class="col-lg-1"></div>
					<?php

						for ($i=0; $i < 5; $i++) {
							echo "<div class='col-lg-2'>";
		                    echo $fields[$i]."<br>";
		                    echo "<select id='box_". $i . "'class='custom-select' style='width:75%;' name=". substr($fields[$i], strripos($fields[$i], " ")) ."><br>";
		                    echo "<option value=-1 selected> Select Field </option><br>";
		                    foreach ($questions as $question) {
		                       if ($i === 1) {
		                            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
		                                if ($question['type'] === "control_email")
		                                    echo  "<option value=". $question['qid'].">". $question['text'] ."</option><br>";
		                        }elseif ($i === 3) {
		                            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
		                                if ($question['type'] === "control_textarea")
		                                    echo  "<option value=". $question['qid'].">". $question['text'] ."</option><br>";
		                        }elseif ($i === 4) {
		                            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
		                                if ($question['type'] === "control_datetime")
		                                    echo  "<option value=". $question['qid'].">". $question['text'] ."</option>";
		                        }else  {
		                            if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
		                                if ($question['type'] === "control_textbox")
		                                    echo  "<option value=". $question['qid'].">". $question['text'] ."</option><br>";
		                        }
		                    }
		                    echo "<option value=0> Add a new question </option><br>";
		                    echo "</select>";
		                    echo "<input type='text' id = 'input". $i ."'name='input' placeholder='   Add new field' style='display:none;'/></div>";
	                    }

						if (isset($_POST['submit'])) {

							error_reporting(0);
							$subject_id = $_POST['Subject'];
							$email_id = $_POST['Address'];
							$name_id = $_POST['Name'];
							$content_id = $_POST['Content'];
							$date_id = $_POST['Date'];
							$search = $_POST['search'];
							$in = $_POST['search-in'];

							if (!is_numeric($subject_id)){
								createQuestion($jotformAPI, $valid_form, $subject_id, "Subject");
	                                	//print_r($jotformAPI->getFormQuestions($valid_form));
								$subject_id = getQuestionId($jotformAPI, $valid_form, $subject_id, "control_textbox");
							}
							if (!is_numeric($email_id)){
								createQuestion($jotformAPI, $valid_form, $email_id, "Address");
								$email_id = getQuestionId($jotformAPI, $valid_form, $email_id, "control_email");
							}
							if (!is_numeric($name_id)){
								createQuestion($jotformAPI, $valid_form, $name_id, "Name");
								$name_id = getQuestionId($jotformAPI, $valid_form, $name_id, "control_textbox");
							}
							if (!is_numeric($content_id)){
								createQuestion($jotformAPI, $valid_form, $content_id, "Content");
								$content_id = getQuestionId($jotformAPI, $valid_form, $content_id, "control_textarea");
							}
							if (!is_numeric($date_id)){
								createQuestion($jotformAPI, $valid_form, $date_id, "Date");
								$date_id = getQuestionId($jotformAPI, $valid_form, $date_id, "control_datetime");
							}
	                                
							//echo $subject_id . " " . $email_id . " " . $name_id . " " . $content_id . " " . $date_id . " " . $search . " " . $in . "<br />";
							if ($email_id === "-1" or $name_id === "-1" or $content_id === "-1" or $subject_id === "-1" or $date_id === "-1") {
								# code...
								$error_msg = "You have to select all neccessary field!";
							}else
								if (isset($_SESSION['result'])) {
								    $result = $_SESSION['result'];
								    //echo "SIZE: " . $count($resul);
								    for($i = 1; $i<count($result); $i++) {
								        	//echo "Date: " . $result[$i][4]."<br/><br/>";
								        	$date = date("d-m-Y", strtotime($result[$i][4]));
								            $dates = explode("-",$date);
								            
								            $hour = date("g:i:A", strtotime($result[$i][4]));
								            $hours = explode(":", $hour);							
											$submission = array(
											    $email_id => $result[$i][0],
											    $name_id => $result[$i][1],
											    $content_id => $result[$i][3],
											    $subject_id => $result[$i][2],
											    $date_id."_day" => $dates[0],
											    $date_id."_month" => $dates[1],
											    $date_id."_year" => $dates[2],
											    $date_id."_hour" => $hours[0],
											    $date_id."_min" => $hours[1],
											    $date_id."_ampm" => $hours[2]
											);

	                                        if (gettype(isAvailable($result, $i, $in, $search)) === "integer") {
	                                          	print_r($jotformAPI->createFormSubmission($valid_form, $submission));
	                                        }
	                                        elseif (empty($search)) {
	                                        	if (gettype(stripos($result[$i][2], "security alert")) !== "integer")
	                                        		print_r($jotformAPI->createFormSubmission($valid_form, $submission));
	                                        }
									}

									unset($_SESSION['result']);
									//unset($_SESSION['token']);
									header("Location: successful.php");             
								}
						}
							
							
			}

			function createQuestion($api, $formID, $text_name, $type) {
				if ($type === "Subject") {
					# code...
					$question = array  (
				      'defaultValue' => '',
				      'description' => '',
				      'hint' => '',
				      'inputTextMask' => '',
				      'labelAlign' => 'Auto',
				      'maxsize' => '',
				      'name' => 'name',
				      'order' => 2,
				      'readonly' => 'No',
				      'required' => 'No',
				      'size' => '20',
				      'subLabel' => '',
				      'text' => $text_name,
				      'type' => 'control_textbox',
				      'validation' => 'None'
				  );
				}
				elseif ($type === "Address") {
					# code...
					$question = array  (
					    'allowCustomDomains' => 'No',
					    'allowedDomains' => '',
					    'confirmation' => 'No',
					    'confirmationHint' => 'example@example.com',
					    'confirmationSublabel' => 'Confirm Email',
					    'defaultValue' => '',
					    'description' => '',
					    'disallowFree' => 'No',
					    'domainCheck' => 'No',
					    'hint' => '',
					    'labelAlign' => 'Auto',
					    'maxsize' => '',
					    'name' => 'email',
					    'order' => 2,
					    'readonly' => 'No',
					    'required' => 'No',
					    'size' => '30',
					    'subLabel' => 'example@example.com',
					    'text' => $text_name,
					    'type' => 'control_email',
					    'validation' => 'Email',
					    'verificationCode' => 'No'
					  );
				}
				elseif ($type === "Name") {
					# code...
					$question = array  (
				      'defaultValue' => '',
				      'description' => '',
				      'hint' => '',
				      'inputTextMask' => '',
				      'labelAlign' => 'Auto',
				      'maxsize' => '',
				      'name' => 'name',
				      'order' => 2,
				      'readonly' => 'No',
				      'required' => 'No',
				      'size' => '20',
				      'subLabel' => '',
				      'text' => $text_name,
				      'type' => 'control_textbox',
				      'validation' => 'None'
				  );
				}
				elseif ($type === "Content") {
					# code...
					$question = array  (
						'cols' => '40',
					    'defaultValue' => '',
					    'description' => '',
					    'entryLimit' => 'None-0',
					    'entryLimitMin' => 'None-0',
					    'hint' => '',
					    'labelAlign' => 'Auto',
					    'maxsize' => '',
					    'name' => 'content',
					    'order' => 2,
					    'readonly' => 'No',
					    'required' => 'No',
					    'rows' => '6',
					    'subLabel' => '',
					    'text' => $text_name,
					    'type' => 'control_textarea',
					    'validation' => 'None',
					    'wysiwyg' => 'Disable'    
					  );
				}
				else  {
					$question = array  (
    					'ageVerification' => 'No',
					    'allowTime' => 'Yes',
					    'autoCalendar' => 'No',
					    'dateSeparator' => '-',
					    'days' => 'Sunday|Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday',
					    'defaultDate' => 'none',
					    'defaultTime' => 'none',
					    'description' => '',
					    'format' => 'ddmmyyyy',
					    'labelAlign' => 'Auto',
					    'limitDate' => '{"days":{"monday":"true","tuesday":"true","wednesday":"true","thursday":"true","friday":"true","saturday":"true","sunday":"true"},"future":"true","past":"true","custom":"false","ranges":"false","start":"","end":""}',
					    'liteMode' => 'Yes',
					    'minAge' => '13',
					    'months' => 'January|February|March|April|May|June|July|August|September|October|November|December',
					    'name' => 'date8',
					    'onlyFuture' => 'No',
					    'order' => 2,
					    'readonly' => 'No',
					    'required' => 'No',
					    'startWeekOn' => 'Sunday',
					    'step' => '10',
					    'sublabels' => array (
					      'day' => 'Day',
					      'month' => 'Month',
					      'year' => 'Year',
					      'last' => 'Last Name',
					      'hour' => 'Hour',
					      'minutes' => 'Minutes',
					      'litemode' => 'Date',
					    ),
					    'text' => $text_name,
					    'timeFormat' => 'AM/PM',
					    'today' => 'Today',
					    'type' => 'control_datetime',
					    'validateLiteDate' => 'Yes'
					  );																
				}

				$api->createFormQuestion($formID, $question);
			}

			function getQuestionId($api, $formID, $text_name, $type) {
				$questions = $api->getFormQuestions($formID);
				foreach ($questions as $question) {
				 	# code...
				 	if (array_key_exists("type", $question) and !array_key_exists("headerType", $question))
				 		if ($question['type'] === $type) {
				 			if ($question['text'] === $text_name) {
				 				return $question['qid'];
				 			}
				 		}
				 }

				 return -1; 
			}

			function isAvailable($result, $index ,$part, $target) {
				switch ($part) {
					case '1':
						# code...
						return stripos($result[$index][1], $target);
						break;
					case '2':
						# code...
						return stripos($result[$index][0], $target);
						break;
					case '3':
						# code...
						return stripos($result[$index][2], $target);
						break;
					case '4':
							# code...
						return stripos($result[$index][3], $target);
						break;	
					default:
						# code...
						return false;
						break;
				}
			}

		?>
				<div class="col-lg-1"></div>
				</div>
				<div class="row" id="search">
					<div class="col-lg-1"></div>
					<div class="col-lg-5">
						<input class="form-control amber-border" type="text" 
						placeholder="Search" aria-label="Search" 
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
				<button type='submit' name= "submit" class='btn btn-warning btn-lg' id="submit"> Integrate </button>
			</form>
			<span id="error" align="center"> <?php echo $error_msg; ?></span>
		</div>

		<footer class="footer" id="footer">
		    <div class="footer-copyright text-center py-3">Powered by
		    	<a class="btn" target="_blank" id="link1" href="https://www.jotform.com/"> JotForm  </a>
		    	|
				<a class="btn" target="_blank" id="link2" href="https://www.jotform.com/apps/"> JotForm Apps</a>
			</div>
		</footer>
	
	</div>
	      
	
<script type="text/javascript" src="reform.js"></script>
</body>
</html>





<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache');
include_once('includes/connection.php');
include_once('includes/classes.php');
include_once('includes/functions.php');

//create object to retrieve schools for dropdown
$school = new School;
$school_fetch = $school->fetch_all();

//initialize variables to detect form submit and errors
$form_submitted = false;
$error_detected = false;

//if submit button is clicked
if(isset($_POST['submit'])){
	$form_submitted = true;
	if(isset($_POST['name']) && strlen($_POST['name'])>3){
		$name = strip_tags($_POST['name']);
	}else{
		$error_detected = true;
		$error = 'Name must be 4 characters at least' . '<br>';
	}
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
		if ($email != '' && strlen($email) < 60 && filter_var($email, FILTER_VALIDATE_EMAIL)){
			$email = strip_tags(trim($email));
		}else{
			$error_detected = true;
			$error .= 'Email in an invalid format' . '<br>';
		}
	}else{
		$error_detected = true;
		$error .= 'Email is required';
	}
	if(isset($_POST['school']) && strlen($_POST['school'])>3){
		$school = strip_tags(trim($_POST['school']));
	}else{
		$error_detected = true;
		$error .= 'School must be 4 characters at least' . '<br>';
	}
	
}

//if input fields are valid
if ($form_submitted == true && $error_detected == false){
	$error = '';
	//object to insert new mamber in DB
	$insert = new Members;
	$insert_member = $insert->update_member($email, $name, $school);
	//error is generated if primary keys in Member_school table already exist
	$error .= $insert_member;
}
?>
<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>School Database</title>
	<meta name="description" content="#">
	<meta name="author" content="Panino">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<!--[if lt IE 9]>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>

<body class = "site">
	<header>
		<p>List of <a href = "index.php">members</a></p>
	</header>
	<section id = "add-student">
		<h1>Add a Member to Schools!</h1>
		<article>
			<div class = "container">
				<div class = "row">
					<div class="col-md-12">
						<div class = "form-container">
							<?php if(isset($error)){ ?>
							<div class="alert alert-danger">
								<p class = "error"> <?php echo $error; ?></p>
							</div><!--/.alert alert-danger-->
							<?php } ?>
							<form method="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form" id="add-form" autocomplete="off" name = "member-form">
								<div class="form-group">
									<label for="name-surname">Enter Member name</label>
									<input type="text" class="form-control" id="name-surname" name = "name"aria-describedby="nameHelp" placeholder="Enter name" minlength="4" required>
								</div><!--/.form-group-->
								<div class="form-group">
									<label for="email-member">Enter Email address</label>
									<input type="email" class="form-control" id="email-member" name = "email" aria-describedby="emailHelp" placeholder="Enter email" required>
								</div><!--/.form-group-->
								<div class="form-group school-input">
									<label for="school-name">Enter Member school</label>
									<input type="text" class="form-control" id="school-name" name = "school" aria-describedby="nameHelp" placeholder="Enter school" minlength="4" required>
								</div><!--/.form-group school-input-->
								<div class="form-group school-selector">
									<label for="school-list">Or choose from current list</label>
									<select class="form-control" id="school-list">
										<option value="0">Select school</option>
										<?php foreach($school_fetch as $school_name) { ?>
										<option value = "<?php echo $school_name['school_id'] ?>">
											<?php echo $school_name['school_name'] ?>
										</option>
										<?php } ?>
									</select>
								</div><!--/.form-group school-selector-->
								<div class="form-group button-input">
									<button type="submit" class="btn btn-primary" name = "submit">Submit</button>
								</div><!--/.form-group button-input-->
							</form>
						</div><!--./form-container-->
					</div><!--/.md-col-12-->
				</div><!--/.row-->
			</div><!--/.container-->
		</article>
	</section><!--/add-student-->
	<footer>
		<p>Created by <a href ="http://www.paninopanini.co.uk/" target = "_blank">Panino Panini</a></p>
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="js/script.js"></script>
	<script>
		//validate form
		$("#add-form").validate();
	</script>
</body>
</html>
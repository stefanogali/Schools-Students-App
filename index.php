<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache');
include_once('includes/connection.php');
include_once('includes/classes.php');
//craete DB tables if not exist
$create_db = new Database;
$create_db->set_db_tables();

//create object to retrieve schools for dropdown
$school = new School;
$school_fetch = $school->fetch_all();

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
		<p>Add a new member <a href = "add.php">here</a></p>
	</header>
	<section id = "students-list">
		<h1>Check the school's members!</h1>
		<article>
			<div class = "container">
				<div class = "row">
					<div class="col-md-12">
						<div class = "select-container">
							<select id = "school-selector">
								<option value="0" disabled selected>Select school</option>
								<?php foreach($school_fetch as $school_name) { ?>
								<option value = "<?php echo $school_name['school_id'] ?>">
									<?php echo $school_name['school_name'] ?>
								</option>
								<?php } ?>
							</select>
						</div><!--/.select-container-->
						<div class = "students-details"></div><!--/.student-details-->
					</div><!--/.col-md-12-->
				</div><!--/.row-->
			</div><!--/.container-->
		</article>
	</section><!--/.student-list-->
	<footer>
		<p>Created by <a href ="http://www.paninopanini.co.uk/" target = "_blank">Panino Panini</a></p>
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>
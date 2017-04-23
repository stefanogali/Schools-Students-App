<?php
include_once('connection.php');
include_once('classes.php');
//get school id from index page
if(!empty($_POST["id"])){
    $id = $_POST["id"];
    $school = new School;
	$school_name = $school->get_school_name($id);
	echo '<h3 class = "school-names">Students at ' . $school_name['school_name'] . '</h3>';
	$school_members = $school->get_member_details($id);
	echo print_members_details($school_members);
}
//print member details in table
function print_members_details($fetched){
	$html = '';
	$html .= '<table id = "table-output">
				<tr>
    				<th>Name</th>
    				<th>Email address</th> 
  				</tr>';
  	foreach($fetched as $school_details){
		$html .= '<tr><td>' . $school_details['member_name'] . '</td>';
		$html .= '<td>' . $school_details['member_email'] . '</td> </tr>';
	}
	$html .= '</table>';
	return $html;
}
?>
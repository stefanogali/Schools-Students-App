<?php

//insert your database details here
$dsn = 'mysql:dbname=INSERT DB NAME HERE;host=INSERT HOST HERE';
$user = 'DB USER HERE';
$password = 'DB PASSWORD HERE';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage(). '<br>';
    echo "Oops...something went wrong. Please check you have entered the correct details for the database credentials";
}

?>
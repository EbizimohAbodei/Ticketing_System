<?php 
$hostName = "eu-cdbr-west-02.cleardb.net";
$databaseName = "ticketingSystem";
$dbuser = "bb1cf7d03be923";
$dbpass = "8022c686";

// Creating the connection to database
$connection = new mysqli($hostName, $dbuser, $dbpass, $databaseName);


// Creating a function to sanitaze user input, preventing SQL injection attacks 
function sanitazeInputs($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

mysql://bb1cf7d03be923:8022c686@eu-cdbr-west-02.cleardb.net/heroku_e68e200e7bb6763?reconnect=true

?>
<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'usersrv01.cs.virginia.edu');
define('DB_USERNAME', 'jg6sa');
define('DB_PASSWORD', 'CS4750group20!');
define('DB_NAME', 'jg6sa_olympics');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
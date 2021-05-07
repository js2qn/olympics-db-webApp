<?php
$username = '';
if($_SESSION["usertype"] == 1){
    $username = 'jg6sa_a';
}
else {
  $username = 'jg6sa_b';
}
$SERVER = 'usersrv01.cs.virginia.edu';
$USERNAME = $username;
$PASSWORD = 'CS4750group20!';
$DATABASE = 'jg6sa';
?>


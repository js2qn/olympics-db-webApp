<?php
 include_once("./library.php"); // To connect to the database
 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);

$ID = mysqli_real_escape_string($con, $_GET['ID']);

if (mysqli_connect_errno())
 {
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }
 // Form the SQL query (an INSERT query)
 $sql="UPDATE athlete SET clickCnt = clickCnt + 1 WHERE ID = $ID";
 $query ="SELECT Name FROM athlete NATURAL JOIN AthleteParticipates WHERE ID = '$ID' LIMIT 1";
 $result = mysqli_query($con, $query);
 $row = mysqli_fetch_array($result);
 // Echo page content
 echo $row['Name'];

 if (!mysqli_query($con,$sql))
 {
 die('Error: ' . mysqli_error($con));
 }
 echo " -- was clicked"; // Output to user

mysqli_close($con);
?>

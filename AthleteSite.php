<?php
 include_once("./library.php"); // To connect to the database
 $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);

$ID = mysqli_real_escape_string($con, $_GET['ID']);

$query ="SELECT Name FROM athlete NATURAL JOIN AthleteParticipates WHERE ID = '$ID' LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
// Echo page content
echo $row['Name'];
mysqli_close($con);
?>
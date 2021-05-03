<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php
//CSS source https://onepagelove.com/minimal-resume
require "dbutil.php";
$db = DbUtil::loginConnection();
$stmtCity = $db->stmt_init();
$stmt = $db->stmt_init();
$stmtE = $db->stmt_init();

echo '<div style="float: right;"><a href="login.php">Home </a></div>';
if($stmtCity->prepare("SELECT City FROM location WHERE Games = ? ORDER BY City") or die(mysqli_error($db))) {
    $gameID =  $_GET['Games'] ;
    echo "<head>
	<title>GameSite</title>
	<link rel='stylesheet' type='text/css' href='styles.css'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>
	<div class='container'>
		<div class='hero'>
			<h1 class='name'><strong>$gameID</strong></h1>";
    $stmtCity->bind_param(i, $gameID);
    $stmtCity->execute();
    $stmtCity->bind_result($City);
    while($stmtCity->fetch()) {
        echo "<span class='email'>$City</span>";
    }
    echo "</table></div></div>";
    $stmtCity->close();
}

if($stmt->prepare("SELECT DISTINCT Team, NOC FROM TeamParticipates WHERE Games = ? ORDER BY Team") or die(mysqli_error($db))) {
    $gameID =  $_GET['Games'] ;
    $stmt->bind_param(i, $gameID);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0) {
        $stmt->bind_result($Team, $NOC);
        echo "<div class='container cards'>
			<h2 class='section-title'>Participated Teams</h2>";
        echo "<table class='table table-hover table-bordered' border=0><th></th><th></th>\n";
        while($stmt->fetch()) {
            echo "<tr><td>$Team, $NOC;</td>";
            echo '<td><a href="TeamSite.php?Team='. $Team .'&amp;NOC='. $NOC .'">View More</a></td></tr>';
        }
        echo "</table></div>";
    }
    $stmt->close();
}

if($stmtE->prepare("SELECT DISTINCT Event FROM GameEvent WHERE Games = ? ORDER BY Event") or die(mysqli_error($db))) {
    $gameID =  $_GET['Games'] ;
    $stmtE->bind_param(i, $gameID);
    $stmtE->execute();
    $stmtE->store_result();
    if($stmtE->num_rows > 0) {
        $stmtE->bind_result($Event);
        echo "<div class='container cards'>
        <h2 class='section-title'>Events: </h2>";
        echo "<table class='table table-hover table-bordered' border=0><th></th>\n";
        while($stmtE->fetch()) {
            echo "<tr><td>$Event</td></tr>\n";
        }
        echo "</table></div>";
    }
    $stmtE->close();
}

$db->close();
?>
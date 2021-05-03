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
require "dbutil.php";
$db = DbUtil::loginConnection();
$stmtCity = $db->stmt_init();
$stmt = $db->stmt_init();
$stmtE = $db->stmt_init();

if($stmtCity->prepare("SELECT City FROM location WHERE Games = ? ORDER BY City") or die(mysqli_error($db))) {
    $gameID =  $_GET['Games'] ;
    echo "<b>$gameID</b></br>";
    $stmtCity->bind_param(i, $gameID);
    $stmtCity->execute();
    $stmtCity->bind_result($City);
    echo "<b>Host: </b>\n";
    echo "<table class='table table-hover table-bordered' border=0><th></th>\n";
    while($stmtCity->fetch()) {
        echo "<tr><td>$City;</td></tr>\n";
    }
    echo "</table>";
    $stmtCity->close();
}

if($stmt->prepare("SELECT DISTINCT Team, NOC FROM TeamParticipates WHERE Games = ? ORDER BY Team") or die(mysqli_error($db))) {
    $gameID =  $_GET['Games'] ;
    $stmt->bind_param(i, $gameID);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0) {
        $stmt->bind_result($Team, $NOC);
        echo "<b>Participated Teams: </b>\n";
        echo "<table class='table table-hover table-bordered' border=0><th></th>\n";
        while($stmt->fetch()) {
            echo "<tr><td>$Team, $NOC;</td></tr>\n";
        }
        echo "</table>";
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
        echo "<b>Events: </b>\n";
        echo "<table class='table table-hover table-bordered' border=0><th></th>\n";
        while($stmtE->fetch()) {
            echo "<tr><td>$Event</td></tr>\n";
        }
        echo "</table>";
    }
    $stmtE->close();
}

$db->close();
?>
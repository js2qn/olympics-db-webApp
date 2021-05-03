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

$stmt = $db->stmt_init();
$stmtBasic = $db->stmt_init();
$stmtATG = $db->stmt_init();
$stmtMedals = $db->stmt_init();
//add one to the clickCnt
if($stmt->prepare("UPDATE athlete SET clickCnt = clickCnt + 1 WHERE ID = ?") or die(mysqli_error($db))) {
    $athID =  $_GET['ID'] ;
    $stmt->bind_param(i, $athID);
    $stmt->execute();
    $stmt->bind_result($clickCnt);
    $stmt->close();
}

//print out the basic info
if($stmtBasic->prepare("SELECT * FROM athlete WHERE ID = ? LIMIT 1") or die(mysqli_error($db))) {
    $athID =  $_GET['ID'] ;
    $stmtBasic->bind_param(i, $athID);
    $stmtBasic->execute();
    $stmtBasic->bind_result($ID, $Name, $Sex, $Height, $Weight, $clickCnt, $popular);
    echo "<table class='table table-hover table-bordered' border=1><th>ID</th><th>Name</th><th>Sex</th><th>Height</th><th>Weight</th>\n";
    while($stmtBasic->fetch()) {
        if($popular == "YES"){ echo "<tr><td>$ID</td><td>$Name &#9734;</td><td>$Sex</td><td>$Height</td><td>$Weight</td>"; }
            else{ echo "<tr><td>$ID</td><td>$Name</td><td>$Sex</td><td>$Height</td><td>$Weight</td>"; }
            echo '</tr>';
        }
        echo "</table>";

        $stmtBasic->close();
    }

//print out the game and event the athlete was in 
//stored procedure used;
if($stmtATG->prepare("SELECT Games, Age, Team, NOC, Event FROM athlete NATURAL JOIN AthleteParticipates NATURAL JOIN PlaysEvent WHERE ID = ?;") or die(mysqli_error($db))){
    $athID =  $_GET['ID'] ;
    $stmtATG->bind_param(i, $athID);
    $stmtATG->execute();
    $stmtATG->store_result();
    if($stmtATG->num_rows > 0) {
        $stmtATG->bind_result($Games, $Age, $Team, $NOC, $Event);
        echo "<b>Games: </b>\n";
        echo "<table class='table table-hover table-bordered' border=0><th></th><th></th><th></th><th></th>\n";
        $firstRow = $stmtATG->fetch();
        echo "<tr><td>$Games;</td><td>Age: $Age;</td><td>Team: $Team, $NOC;</td><td>$Event;</td>\n";
        $lastAge = $Age;
        while($stmtATG->fetch()) {
            if($Age == $lastAge){
                echo "<tr>&nbsp;<td>&nbsp;</td>&nbsp;<td>&nbsp;</td><td>&nbsp;</td><td>$Event;</td></tr>\n";
            }
            else{
                $lastAge = $Age;
                echo "<tr><td>$Games;</td><td>Age: $Age;</td><td>Team: $Team, $NOC;</td><td>$Event;</td></tr>\n";}
        }
        echo "</table>";
    }
    $stmtATG->close();
}

//print out medals
if($stmtMedals->prepare("CALL AthMedal(?)")or die(mysqli_error($db))){
    $athID =  $_GET['ID'] ;
    $stmtMedals->bind_param(i, $athID);
    $stmtMedals->execute();
    $stmtMedals->store_result();
    if($stmtMedals->num_rows > 0) {
        $stmtMedals->bind_result($Games, $Medal);
        echo "<b>Medals</b></br>";
        while($stmtMedals->fetch()){
            echo "<p>$Games; $Medal</p>\n";
        }
    }
    $stmtMedals->close();
}

$db->close();
?>

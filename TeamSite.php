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

if($stmt->prepare("SELECT DISTINCT Games FROM TeamParticipates WHERE Team = ? and NOC = ? ORDER BY Games") or die(mysqli_error($db))) {
    $teamID =  $_GET['Team'] ;
    $NOCID = $_GET['NOC'];
    $stmt->bind_param(ii, $teamID, $NOCID);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0) {
        $stmt->bind_result($Games);
        echo "<b>Past Games: </b>\n";
        echo "<table class='table table-hover table-bordered' border=0><th></th><th></th>\n";
        while($stmt->fetch()) {
            echo "<tr><td>$Games;</td>";
            echo '<td><a href="GameSite.php?Games='. $Games .'">View More</a></td></tr>';
        }
        echo "</table>";
    }
    $stmt->close();
}

$db->close();
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
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

        if($stmt->prepare("select * from game_name where Games like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['gamesOfInterest'] . '%';
                $stmt->bind_param(s, $searchString);
                $stmt->execute();
                $stmt->bind_result($Games, $Year, $Season);
                echo "<table class='table table-hover table-bordered' border=1><th>Games</th><th>Year</th><th>Season</th><th>Details</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$Games</td><td>$Year</td><td>$Season</td>";
                        echo '<td><a href="GameSite.php?Games='. $Games .'">View More</a></td></tr>';
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>

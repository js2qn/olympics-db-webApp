
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

        if($stmt->prepare("select * from team where Team like ? OR NOC like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['teamNameORnoc'] . '%';
                $stmt->bind_param(ss, $searchString, $searchString);
                $stmt->execute();
                $stmt->bind_result($Team, $NOC);
                echo "<table class='table table-hover table-bordered' border=1><th>Team</th><th>NOC</th><th>Details</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$Team</td><td>$NOC</td>";
			echo '<td><a href="teamSite.php?Team='. $Team .'">View More</a></td></tr>';
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>

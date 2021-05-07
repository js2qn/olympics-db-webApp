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

        if($stmt->prepare("select * from athlete where Name like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['searchName'] . '%';
                $stmt->bind_param('s', $searchString);
                $stmt->execute();
                $stmt->bind_result($ID, $Name, $Sex, $Height, $Weight, $clickCnt, $popular);
                echo "<table class='table table-hover table-bordered' border=1><th>ID</th><th>Name</th><th>Sex</th><th>Height</th><th>Weight</th><th>Details</th>\n";
                while($stmt->fetch()) {
			if($popular == "YES"){ echo "<tr><td>$ID</td><td>$Name &#9734;</td><td>$Sex</td><td>$Height</td><td>$Weight</td>"; }
                        else{ echo "<tr><td>$ID</td><td>$Name</td><td>$Sex</td><td>$Height</td><td>$Weight</td>"; }
                        echo '<td><a href="AthleteSite.php?ID='. $ID .'">View More</a></td></tr>';
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>

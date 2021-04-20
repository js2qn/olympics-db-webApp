
<?php
        require "dbutil.php";
        $db = DbUtil::loginConnection();

        $stmt = $db->stmt_init();

        if($stmt->prepare("select * from athlete where Name like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['searchName'] . '%';
                $stmt->bind_param(s, $searchString);
                $stmt->execute();
                $stmt->bind_result($ID, $Name, $Sex, $Height, $Weight);
                echo "<table border=1><th>ID</th><th>Name</th><th>Sex</th><th>Height</th><th>Weight</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$ID</td><td>$Name</td><td>$Sex</td><td>$Height</td><td>$Weight</td></tr>";
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>

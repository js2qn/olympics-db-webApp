<?php
        require "dbutil.php";
        $db = DbUtil::loginConnection();

        $stmt = $db->stmt_init();

        if($stmt->prepare("select * from team where Team like ? OR NOC like ?") or die(mysqli_error($db))) {
                $searchString = '%' . $_GET['teamNameORnoc'] . '%';
                $stmt->bind_param(ss, $searchString, $searchString);
                $stmt->execute();
                $stmt->bind_result($Team, $NOC);
                echo "<table border=1><th>Team</th><th>NOC</th>\n";
                while($stmt->fetch()) {
                        echo "<tr><td>$Team</td><td>$NOC</td></tr>";
                }
                echo "</table>";

                $stmt->close();
        }

        $db->close();


?>
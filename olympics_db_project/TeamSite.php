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

$stmt = $db->stmt_init();
echo '<div style="float: right;"><a href="login.php">Home </a></div>';
if($stmt->prepare("SELECT DISTINCT Games FROM TeamParticipates WHERE Team = ? and NOC = ? ORDER BY Games") or die(mysqli_error($db))) {
    $teamID =  $_GET['Team'] ;
    $NOCID = $_GET['NOC'];
    $stmt->bind_param(ii, $teamID, $NOCID);
    $stmt->execute();
    $stmt->store_result();
    echo "<head>
	<title>TeamSite</title>
	<link rel='stylesheet' type='text/css' href='styles.css'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>
	<div class='container'>
		<div class='hero'>
			<h1 class='name'><strong>$teamID,</strong> $NOCID</h1>
		</div>
	</div>";
    if($stmt->num_rows > 0) {
        $stmt->bind_result($Games);
        echo "<div class='container cards'>
        <h2 class='section-title'>Past Games:</h2>";
        echo "<table class='table table-hover table-bordered' border=0><th></th><th></th>\n";
        while($stmt->fetch()) {
            echo "<tr><td>$Games;</td>";
            echo '<td><a href="GameSite.php?Games='. $Games .'">View More</a></td></tr>';
        }
        echo "</table></div>";
    }
    $stmt->close();
}

$db->close();
?>
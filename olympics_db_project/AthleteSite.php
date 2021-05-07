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
echo '<div style="float: right;"><a href="login.php">Home </a></div>';
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
    echo '<head>
	<title>AthleteSite</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"></head>';
    while($stmtBasic->fetch()) {
        if($popular == "YES"){ 
            echo "<body>

            <div class='container'>
                <div class='hero'>
                    <h1 class='name'><strong>$Name</strong></h1>
                    <span class='job-title'>&#9734</span>
                </div>
            </div>"; 
        }
        else{ 
            echo "<body>

            <div class='container'>
                <div class='hero'>
                    <h1 class='name'><strong>$Name</strong></h1>
                </div>
            </div>";
        }
        echo "<div class='container'>
        <div class='sections'>
			<h2 class='section-title'>Basic Information</h2>

			<div class='list-card'>
				<span class='exp'>Gender</span>
				<div>
					<h3>$Sex</h3>
				</div>
			</div>
			
			<div class='list-card'>
				<span class='exp'>Height</span>
				<div>
					<h3>$Height</h3>
				</div>
			</div>	
					
			<div class='list-card'>
				<span class='exp'>Weight</span>
				<div>
					<h3>Weight</h3>
				</div>
			</div>


		</div>
	</div>";
        }
        $stmtBasic->close();
    }

//print out the game and event the athlete was in 
if($stmtATG->prepare("SELECT Games, Age, Team, NOC, Event FROM athlete NATURAL JOIN AthleteParticipates NATURAL JOIN PlaysEvent WHERE ID = ?;") or die(mysqli_error($db))){
    $athID =  $_GET['ID'] ;
    $stmtATG->bind_param(i, $athID);
    $stmtATG->execute();
    $stmtATG->store_result();
    if($stmtATG->num_rows > 0) {
        $stmtATG->bind_result($Games, $Age, $Team, $NOC, $Event);
        echo "<div class='container cards'>
			<h2 class='section-title'>Games</h2>";
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
        echo "</table></div>";
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
        $stmtMedals->bind_result($Games, $Medal, $Event);
        echo "<div class='container cards'>";
        while($stmtMedals->fetch()){
            echo "<div class='card'>
			<div class='skill-level'>
				<span>won</span>
				<h2>$Medal</h2>
			</div>

			<div class='skill-meta'>
				<h3>$Games</h3>
                <span>$Event</span>
			</div>
		</div>";
        }
        echo "</body>";
    }
    $stmtMedals->close();
}

$db->close();
?>

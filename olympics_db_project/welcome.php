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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our Olympics site.</h1>
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Olympic_rings_without_rims.svg" alt="Olympics logo">
    <br><br>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    <p>
        <a href="index_Games.html" class="btn btn-primary">Search Games</a>
        <a href="index_Names.html" class="btn btn-primary">Search Names</a>
        <a href="index_Teams.html" class="btn btn-primary">Search Teams</a>
    </p>
    <?php
        if($_SESSION["usertype"] == 1) {
            echo '<p>
            <a href="insert.html" class="btn btn-secondary">Insert</a>
            <a href="update.html" class="btn btn-secondary">Update</a>
            <a href="delete.html" class="btn btn-secondary">Delete</a>
            </p>';
        }
    ?>
    
</body>
</html>
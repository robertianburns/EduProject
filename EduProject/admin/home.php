<?php
session_start();

/*
  Check if the end user is already logged in. If not, redirect to login page. */
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

/*
  Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "functions/database.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Home (admin) - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="stylesheet" href="css/admin.css" />
</head>

<body>

        <div class="white-box">

            <h1>Admin home page</h1>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>

            <h3>Admin options:</h3>
            <a href="content.php" class="button blue-button"> Add or edit EduProject content </a>
            <a href="quiz.php" class="button blue-button"> Add or edit EduProject quizzes </a>

            <h3>Account options:</h3>
            <a href="resetpassword.php" class="button red-button"> Reset Your Password </a>
            <a href="functions/logout.php" class="button red-button"> Sign Out of Your Account </a>

    </div>

</body>

</html>
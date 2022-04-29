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

/*
  Get the experience. This is got when the page is loaded so it is always up to date. If stored in a session variable, the experience number won't update during the session. */
$experienceQuery = $connection->query("SELECT experience FROM accounts_details WHERE username = '" . $_SESSION["username"] . "'");
$experienceResult = mysqli_fetch_array($experienceQuery);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title><?php echo htmlspecialchars($_SESSION["username"]); ?>'s Profile - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js" defer></script>
</head>

<body class="coloured-body">

    <div class="profile-header">
        <?php
        include_once('components/navbar.php');
        ?>
        <h1 class="responsive-h1"><?php echo htmlspecialchars($_SESSION["username"]); ?>'s profile</h1>
    </div>

    <div class="margin">
        <div class="white-box profile">
            <h1>Account milestones:</h1>
            <h4>You have <b><?php echo $experienceResult['experience']; ?></b> experience!</h4>

            <?php
            $query = "SELECT * FROM accounts_progress WHERE username = '" . $_SESSION["username"] . "'";
            $result = $connection->query($query);
            $row = $result->fetch_assoc();

            if ($row['webdev_html_done'] == 1) {
                echo "<h5 class='completed'>You have completed Web Development's HTML section!</h5>";
            } else {
                echo "<h5 class='not-completed'>You have not yet completed Web Development's HTML section!</h5>";
            }

            if ($row['webdev_css_done'] == 1) {
                echo "<h5 class='completed'>You have completed Web Development's CSS section!</h5>";
            } else {
                echo "<h5 class='not-completed'>You have not yet completed Web Development's CSS section!</h5>";
            }

            if ($row['webdev_javascript_done'] == 1) {
                echo "<h5 class='completed'>You have completed Web Development's JavaScript section!</h5>";
            } else {
                echo "<h5 class='not-completed'>You have not yet completed Web Development's JavaScript section!</h5>";
            }

            if ($row['webdev_quiz_done'] == 1) {
                echo "<h5 class='completed'>You have completed Web Development's quiz!</h5>";
            } else {
                echo "<h5 class='not-completed'>You have not yet completed Web Development's quiz!</h5>";
            }

            if ($row['java_intro_done'] == 1) {
                echo "<h5 class='completed'>You have completed Java Programming's The ins and outs section!</h5>";
            } else {
                echo "<h5 class='not-completed'>You have not yet completed Java Programming's The ins and outs section!</h5>";
            }

            if ($row['java_fundamentals_done'] == 1) {
                echo "<h5 class='completed'>You have completed Java Programming's Object oriented section!</h5>";
            } else {
                echo "<h5 class='not-completed'>You have not yet completed Java Programming's Object oriented section!</h5>";
            }

            if ($row['webdev_quiz_done'] == 1) {
                echo "<h5 class='completed'>You have completed Java Programming's quiz!</h5>";
            } else {
                echo "<h5 class='not-completed'>You have not yet completed Java Programming's quiz!</h5>";
            }

            $connection->close();
            ?>

        </div>

        <div class="white-box">
            <h1>Account options:</h1>
            <a href="resetpassword.php" class="button blue-button"> Reset Your Password </a>
            <a href="functions/logout.php" class="button red-button"> Sign Out of Your Account </a>
        </div>
    </div>

    <?php
    require_once('components/footer.php');
    ?>

</body>

</html>
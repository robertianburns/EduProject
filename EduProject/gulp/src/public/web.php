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
  Complete HTML, CSS, and JavaScript button logic. */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['htmlDone'])) {
            // Give experience.
            $experienceQuery = $connection->prepare("UPDATE accounts_details SET experience = experience + 20 WHERE username = '" . $_SESSION["username"] . "'");
            $experienceQuery->execute();
            // Change the progress value to 1 to show they completed that section.
            $progressQuery = $connection->prepare("UPDATE accounts_progress SET webdev_html_done = 1 WHERE username = '" . $_SESSION["username"] . "'");
            $progressQuery->execute();

            $experienceQuery->close();
            $progressQuery->close();
            header('Location: web.php');
        } elseif (isset($_POST['cssDone'])) {
            $experienceQuery = $connection->prepare("UPDATE accounts_details SET experience = experience + 20 WHERE username = '" . $_SESSION["username"] . "'");
            $experienceQuery->execute();
            $progressQuery = $connection->prepare("UPDATE accounts_progress SET webdev_css_done = 1 WHERE username = '" . $_SESSION["username"] . "'");
            $progressQuery->execute();

            $experienceQuery->close();
            $progressQuery->close();
            header('Location: web.php');
        } elseif (isset($_POST['jsDone'])) {
            $experienceQuery = $connection->prepare("UPDATE accounts_details SET experience = experience + 20 WHERE username = '" . $_SESSION["username"] . "'");
            $experienceQuery->execute();
            $progressQuery = $connection->prepare("UPDATE accounts_progress SET webdev_javascript_done = 1 WHERE username = '" . $_SESSION["username"] . "'");
            $progressQuery->execute();

            $experienceQuery->close();
            $progressQuery->close();
            header('Location: web.php');
        } else {
            echo "ERROR CODE PIGEON: That request couldn't be processed. Please try again!";
        }
    }
}

/*
  Change 'complete HTML, CSS, and JavaScript' to text if already pressed. */
$checklistQuery = "SELECT * FROM accounts_progress WHERE username = '" . $_SESSION["username"] . "'";
$result = $connection->query($checklistQuery);
$row = $result->fetch_assoc();

if ($row['webdev_html_done'] == 1) {
    $htmlButton = "<h5 class='completed'>You have already completed the HTML section!</h5>";
} else {
    $htmlButton = '<form action="" method="post"><button name="htmlDone" class="button redeem-button"> Completed the HTML section? Click and get 20 experience! </button></form>';
}

if ($row['webdev_css_done'] == 1) {
    $cssButton = "<h5 class='completed'>You have already completed the CSS section!</h5>";
} else {
    $cssButton = '<form action="" method="post"><button name="cssDone" class="button redeem-button"> Completed the CSS section? Click and get 20 experience! </button></form>';
}

if ($row['webdev_javascript_done'] == 1) {
    $javascriptButton = "<h5 class='completed'>You have already completed the JavaScript section!</h5>";
} else {
    $javascriptButton = '<form action="" method="post"><button name="jsDone" class="button redeem-button"> Completed the JavaScript section? Click and get 20 experience! </button></form>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Web Development - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/web.js" defer></script>
</head>

<body class="coloured-body">

    <div class="webdev-header">
        <?php
        include_once('components/navbar.php');
        ?>
        <h1>Website Development</h1>
    </div>

    <div class="margin">
        <div class="paragraph">
            <?php
            $contentQuery = "SELECT * FROM content WHERE module = 'webdev' order by section_number ASC";
            $result = $connection->query($contentQuery);

            if ($connection && ($result->num_rows > 0)) {
                while ($row = $result->fetch_assoc()) {
                    echo $row["section_text"] . "<br>";
                }
            } else {
                echo "ERROR CODE BANANA: Could not retrieve Web Development text!";
            }
            ?>
        </div>

        <div class="white-box">
            <div class="checklist">
                <h1>Checklist</h1>
                <?php
                echo $htmlButton;
                echo $cssButton;
                echo $javascriptButton;
                ?>
            </div>
        </div>

        <div class="parent">
            <a href="webquiz.php" class="button blue-button"> Test your knowledge and take the Web Development quiz!
            </a>
        </div>

        <?php
        require_once('components/footer.php');
        ?>

</body>

</html>
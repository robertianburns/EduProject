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
        if (isset($_POST['introDone'])) {
            // Give experience.
            $experienceQuery = $connection->prepare("UPDATE accounts_details SET experience = experience + 20 WHERE username = '" . $_SESSION["username"] . "'");
            $experienceQuery->execute();

            // Change the progress value to 1 to show they completed that section.
            $progressQuery = $connection->prepare("UPDATE accounts_progress SET java_intro_done = 1 WHERE username = '" . $_SESSION["username"] . "'");
            $progressQuery->execute();

            $experienceQuery->close();
            $progressQuery->close();
            header('Location: java.php');
        } elseif (isset($_POST['fundamentalsDone'])) {
            $experienceQuery = $connection->prepare("UPDATE accounts_details SET experience = experience + 20 WHERE username = '" . $_SESSION["username"] . "'");
            $experienceQuery->execute();

            $progressQuery = $connection->prepare("UPDATE accounts_progress SET java_fundamentals_done = 1 WHERE username = '" . $_SESSION["username"] . "'");
            $progressQuery->execute();

            $experienceQuery->close();
            $progressQuery->close();
            header('Location: java.php');
        } else {
            echo "ERROR CODE HAWK: That request couldn't be processed. Please try again!";
        }
    }
}

/* Change 'complete HTML, CSS, and JavaScript' to text if already pressed. */
$checklistQuery = "SELECT * FROM accounts_progress WHERE username = '" . $_SESSION["username"] . "'";
$result = $connection->query($checklistQuery);
$row = $result->fetch_assoc();

if ($row['java_intro_done'] == 1) {
    $htmlButton = "<h5 class='completed'>You have already completed the The ins and outs section!</h5>";
} else {
    $htmlButton = '<form action="" method="post"><button name="introDone" class="button redeem-button"> Finished the The ins and outs section? Get 20 experience! </button></form>';
}

if ($row['java_fundamentals_done'] == 1) {
    $cssButton = "<h5 class='completed'>You have already completed the Object oriented section!</h5>";
} else {
    $cssButton = '<form action="" method="post"><button name="fundamentalsDone" class="button redeem-button"> Finished the Object oriented section? Get 20 experience! </button></form>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Java Programming - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/java.js" defer></script>
</head>

<body class="coloured-body">

    <div class="java-header">
        <?php
        include_once('components/navbar.php');
        ?>
        <h1>Java Programming</h1>
    </div>

    <div class="margin">

        <div class="paragraph">
            <?php
            $contentQuery = "SELECT * FROM content WHERE module = 'java' order by section_number ASC";
            $result = $connection->query($contentQuery);

            if ($connection && ($result->num_rows > 0)) {
                while ($row = $result->fetch_assoc()) {
                    echo $row["section_text"] . "<br>";
                }
            } else {
                echo "ERROR CODE STEREO: Could not retrieve Java Programming text!";
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
            <a href="javaquiz.php" class="button blue-button"> Test your knowledge and take the almighty quiz! </a>
        </div>

        <?php
        require_once('components/footer.php');
        ?>

</body>

</html>
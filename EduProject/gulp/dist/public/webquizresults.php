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
  Have an array holding the number of correct answers for each question. */
$correctAnswers = $_SESSION["correctAnswers"];
$numberOfCorrectAnswers = 0;
for ($i = 0; $i < count($correctAnswers); $i++) {
    if (isset($_POST[$i])) { // Check if the end user has selected an answer.
        if ($_POST[$i] === $correctAnswers[$i]) {
            $numberOfCorrectAnswers++;
        }
    }
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
    <script src="js/main.js" defer></script>
</head>

<body>

    <div class="webdev-header">
        <?php
        include_once('components/navbar.php');
        ?>
        <h1>Web Development quiz results</h1>
    </div>

    <div class="parent">
        <div class="result">
            <h1>You got <?php echo $numberOfCorrectAnswers ?> out of 25 questions correct!</h1>
            <?php
            if ($numberOfCorrectAnswers >= 15) {
                echo "<h2> Well done! </h2>";
                echo '<div class="parent">';
                echo '<form action="functions/webquizsubmit.php" method="post">';
                echo '<button name="quizSubmit" class="button blue-button"> Submit and redeem 100 experience! </button>';
                echo '</form>';
                echo '</div>';
            } else {
                echo "<h2> You're getting there, but just not yet! </h2>";
                echo "<h3> Get over at least 15 correct to gain experience! </h3>";
            }
            ?>
        </div>
    </div>
    <div class="parent">
        <a href="webquiz.php">
            <button name="quizSubmit" class="button red-button"> Restart quiz! </button>
        </a>
    </div>

    <?php
    include_once('components/footer.php');
    ?>

</body>

</html>
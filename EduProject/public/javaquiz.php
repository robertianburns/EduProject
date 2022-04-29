<?php
session_start();

/*
  Check if the end user is already logged in. If not, redirect to login page. */
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

/*
  Store the number of correct answers for the questions. */
$_SESSION['correctAnswers'] = [];

/*
  Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "functions/database.php";

/*
  Get twenty-five random questions for the quiz. */
$query = $connection->query("SELECT * FROM quiz WHERE module = 'java' ORDER BY RAND() LIMIT 12");
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
    <script src="js/main.js" defer></script>
</head>

<body class="coloured-body">

    <div class="java-header">
        <?php
        include_once('components/navbar.php');
        ?>
        <h1>Java Programming quiz</h1>
    </div>

    <div class="margin">

        <div>
            <form action="javaquizresults.php" method="post">
                <?php
                for ($i = 0; $i < $query->num_rows; $i++) {
                    // Get an array for every element and store the number of correct answers the end user got.
                    $array = $query->fetch_row();
                    array_push($_SESSION['correctAnswers'], $array[6]);

                    echo '<div class="parent">';
                    echo '<div class="quiz">';
                    echo '<table>';
                    echo '<h2> Question ' . ($i + 1) . '</h2>';
                    echo '<h4>' . $array[1] . '</h4>';
                    echo '<br>';
                    echo '<input type="radio" name="' . $i . '" value="1" />';
                    echo ' ' . $array[2];
                    echo '<br>';
                    echo '<input type="radio" name="' . $i . '" value="2" />';
                    echo ' ' . $array[3];
                    echo '<br>';
                    echo '<input type="radio" name="' . $i . '" value="3" />';
                    echo ' ' . $array[4];
                    echo '<br>';
                    echo '<input type="radio" name="' . $i . '" value="4" />';
                    echo ' ' . $array[5];
                    echo '<br>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                }
                $connection->close();
                ?>
                <div class="parent">
                    <button class="button blue-button">Submit</button>
                </div>
            </form>
        </div>

    </div>

    <?php
    require_once('components/footer.php');
    ?>

</body>

</html>
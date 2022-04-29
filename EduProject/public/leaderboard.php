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
    <title>Leader board - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js" defer></script>
</head>

<body>

    <div class="leaderboard-header">
        <?php
        include_once('components/navbar.php');
        ?>
        <h1>Global leader board</h1>
    </div>

    <div class="margin">
        <div class="container">

            <?php
            /* High for the highest experienced account, low for the rest of the population. */
            $highQuery = "SELECT username, experience FROM accounts_details ORDER BY experience DESC LIMIT 1";
            $lowQuery = "SELECT username, experience FROM accounts_details ORDER BY experience DESC LIMIT 1000000 OFFSET 1";

            $highResult = $connection->query($highQuery);
            $lowResult = $connection->query($lowQuery);

            echo "<table>";

            while ($row = mysqli_fetch_array($highResult)) {
                echo "<tr><td class='table-mvp'>" . $row['username'] . "</td><td class='table-mvp'>" . $row['experience'] . "</td></tr>";
            }

            while ($row = mysqli_fetch_array($lowResult)) {
                echo "<tr><td class='table-light'>" . $row['username'] . "</td><td class='table-dark'>" . $row['experience'] . "</td></tr>";
            }

            echo "</table>";
            $highResult->close();
            $lowResult->close();
            $connection->close();
            ?>
        </div>
    </div>

    <?php
    require_once('components/footer.php');
    ?>

    </div>

</body>

</html>
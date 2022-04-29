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
  Quiz */
$quizQuery = "SELECT * FROM quiz";
$quizResult = $connection->query($quizQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../manifest.json" rel="manifest">
    <link rel="shortcut icon" href="images/icon_x48.png" />
    <title>Edit content (admin) - EduProject</title>
    <link rel="stylesheet" href="css/normalise.css" />
    <link rel="stylesheet" href="css/admin.css" />
</head>

<body>

    <div class="margin">

        <div class="white-box">
            <h1>Add or edit the EduProject quiz questions</h1>
            <a href="home.php" class="button blue-button"> Back to admin home </a>
        </div>

        <div class="white-box">
            <div class="tableContainer">
                <h2>Add a quiz question</h2>
                <table>
                    <tr>
                        <th>Question</th>
                        <th>Answer 1</th>
                        <th>Answer 2</th>
                        <th>Answer 3</th>
                        <th>Answer 4</th>
                        <th>Correct answer</th>
                        <th>Module</th>
                    </tr>

                    <tr>
                        <form action="functions/addquizquestion.php" method="post">
                            <td><textarea type="text" name="addQuestion"></textarea></td>
                            <td><input type="text" size="13" name="addAnswer1"></td>
                            <td><input type="text" size="13" name="addAnswer2"></td>
                            <td><input type="text" size="13" name="addAnswer3"></td>
                            <td><input type="text" size="13" name="addAnswer4"></td>
                            <td><input type="number" name="addCorrectAnswer"></td>
                            <td><input type="text" size="5" name="addModule"></td>
                            <td><input type="submit" value="Add question">
                            <td>
                        </form>
                    </tr>
                </table>
            </div>
        </div>

        <div class="white-box">
            <h2>Edit quiz questions</h2>
            <div class="tableContainer">
                <table>
                    <tr>
                        <th>Question</th>
                        <th>Answer 1</th>
                        <th>Answer 2</th>
                        <th>Answer 3</th>
                        <th>Answer 4</th>
                        <th>Correct answer</th>
                        <th>Module</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_array($quizResult)) {
                        echo '<tr><form action="functions/updatequizquestion.php" method="post">';
                        echo '<td><textarea type="text" name="updatedQuestion">' . htmlspecialchars($row['question']) . '</textarea></td>';
                        echo '<td><input type="text" name="updatedAnswer1" size="13" value="' . $row['answer1'] . '"></td>';
                        echo '<td><input type="text" name="updatedAnswer2" size="13" value="' . $row['answer2'] . '"></td>';
                        echo '<td><input type="text" name="updatedAnswer3" size="13" value="' . $row['answer3'] . '"></td>';
                        echo '<td><input type="text" name="updatedAnswer4" size="13" value="' . $row['answer4'] . '"></td>';
                        echo '<td><input type="number" name="updatedCorrectAnswer" value="' . $row['correct'] . '"></td>';
                        echo '<td><input type="text" name="updatedModule" size="5" value="' . $row['module'] . '"></td>';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<td><input type="submit" value="Submit question edit"><td>';
                        echo '</form></tr>';
                    }
                    ?>
                </table>
            </div>
        </div>

    </div>

</body>

</html>
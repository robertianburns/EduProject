<?php
/* Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "database.php";

/* Prepare the statement. */
$quizQuery = $connection->prepare("INSERT INTO quiz (question, answer1, answer2, answer3, answer4, correct, module) VALUES (?, ?, ?, ?, ?, ?, ?)");
$addQuestion = $_POST['addQuestion'];
$addAnswer1 = $_POST['addAnswer1'];
$addAnswer2 = $_POST['addAnswer2'];
$addAnswer3 = $_POST['addAnswer3'];
$addAnswer4 = $_POST['addAnswer4'];
$addCorrectAnswer = $_POST['addCorrectAnswer'];
$addModule = $_POST['addModule'];
$quizQuery->bind_param("sssssis", $addQuestion, $addAnswer1, $addAnswer2, $addAnswer3, $addAnswer4, $addCorrectAnswer, $addModule);

if ($quizQuery->execute()) {
    header("Location: ../quiz.php");
} else {
    echo "ERROR CODE MOUSE (admin): That quiz question addition request couldn't be processed (" . $connection->errno . " - " . $connection->error . ")!";
}

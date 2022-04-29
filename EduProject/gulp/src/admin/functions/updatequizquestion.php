<?php
/* Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "database.php";

/* Prepare the statement. */
$quizQuery = $connection->prepare("UPDATE quiz SET question=?, answer1=?, answer2=?, answer3=?, answer4=?, correct=?, module=? WHERE id=?");
$updatedQuestion = $_POST['updatedQuestion'];
$updatedAnswer1 = $_POST['updatedAnswer1'];
$updatedAnswer2 = $_POST['updatedAnswer2'];
$updatedAnswer3 = $_POST['updatedAnswer3'];
$updatedAnswer4 = $_POST['updatedAnswer4'];
$updatedCorrectAnswer = $_POST['updatedCorrectAnswer'];
$updatedModule = $_POST['updatedModule'];
$id = $_POST['id'];
$quizQuery->bind_param("sssssisi", $updatedQuestion, $updatedAnswer1, $updatedAnswer2, $updatedAnswer3, $updatedAnswer4, $updatedCorrectAnswer, $updatedModule, $id);

if ($quizQuery->execute()) {
    header("Location: ../quiz.php");
} else {
    echo "ERROR CODE ARMADILLO (admin): That quiz question update request couldn't be processed (" . $connection->errno . " - " . $connection->error . ")!";
}

<?php
session_start();

/*
  Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "database.php";

/*
  Prepare the statement. */
$experienceQuery = $connection->prepare("UPDATE accounts_details SET experience = experience + 70 WHERE username = '" . $_SESSION["username"] . "'");
$completedQuery = $connection->prepare("UPDATE accounts_progress SET java_quiz_done = 1 WHERE username = '" . $_SESSION["username"] . "'");

if (($experienceQuery->execute()) && ($completedQuery->execute())) {
    $experienceQuery->close();
    $connection->close();
    header('Location: ../java.php');
} else {
    // Something went wrong...
    echo "ERROR CODE BIRD: That request couldn't be processed. Please try again!";
}

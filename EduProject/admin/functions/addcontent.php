<?php
/* 
  Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "database.php";

/* 
  Prepare the statement. */
$contentQuery = $connection->prepare("INSERT INTO content (module, section_number, section_text) VALUES (?, ?, ?)");
$addModule = $_POST['addModule'];
$addSectionNumber = $_POST['addSectionNumber'];
$addSectionText = $_POST['addSectionText'];
$contentQuery->bind_param("sis", $addModule, $addSectionNumber, $addSectionText);

if ($contentQuery->execute()) {
    header("Location: ../content.php");
} else {
    echo "ERROR CODE SEAGULL (ADMIN): That content addition request couldn't be processed. Please try again!";
    // echo "DEBUG - '$contentQuery->execute()' has failed!: (" . $connection->errno . ") " . $connection->error . "<br>";
}

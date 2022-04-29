<?php
/* Get the database credentials from the database file. If the file was already included, it will not include it again. */
require_once "database.php";

/* Prepare the statement. */
$contentQuery = $connection->prepare("UPDATE content SET module=?, section_number=?, section_text=? WHERE id=?");
$updatedModule = $_POST['updatedModule'];
$updatedSectionNumber = $_POST['updatedSectionNumber'];
$updatedSectionText = $_POST['updatedSectionText'];
$id = $_POST['id'];
$contentQuery->bind_param("sisi", $updatedModule, $updatedSectionNumber, $updatedSectionText, $id);

if ($contentQuery->execute()) {
    header("Location: ../content.php");
} else {
    echo "ERROR CODE PARROT (admin): That content update request couldn't be processed. Please try again!";
    // echo "DEBUG - Prepare has failed!: (" . $connection->errno . ") " . $connection->error . "<br>";
}

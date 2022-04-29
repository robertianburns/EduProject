<?php
session_start();

/* Get rid of all the session variables. */
$_SESSION = array();

/* Destroy all data associated with the current session. */
session_destroy();

/* Redirect the end user to the login page as they have signed out. */
header("Location: ../login.php");
exit;

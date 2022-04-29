<?php
define('databaseHost', 'rib13.brighton.domains');
define('databaseUsername', 'rib13_eduprojectadmin');
define('databasePassword', '=N4]P4em&ub+r6qj');
define('databaseName', 'rib13_eduproject');

/*
  Attempt to connect to MySQL database. */
$connection = new mysqli(databaseHost, databaseUsername, databasePassword, databaseName);

/*
  Kill the connection if there was an error. */
if ($connection->connect_error) {
    die("ERROR CODE PEAR (ADMIN): There was an error when connecting to the server (" . $connection->connect_error . ")!");
}

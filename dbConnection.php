<?php
$databaseHost = 'localhost:3306';
$databaseName = 'loa_progweb2';
$databaseUsername = 'root';
$databasePassword = 'admin123';

// Open a new connection to the MySQL server
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
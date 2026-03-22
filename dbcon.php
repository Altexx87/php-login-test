<?php

$host = 'localhost';
$dbname = 'dbname';       // database name
$username = 'dbusername'; // database username
$password = 'dbpassword'; // !!!! IT IS IMPORTANT YOU CHANGE THIS TO YOUR OWN PASSWORD !!!!

// Data Source Name (DSN) specifies the host, database name, and charset for the connection.
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Turn on errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Make the default fetch be an associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Turn off emulation mode for real prepared statements
];

try {
    // Create the PDO database connection
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Handle connection error
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
?>
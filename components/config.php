<?php
// This file contains database configuration assuming that we are running MySQL using user "root" and password ""
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'email_services');

$error = '';

// Connect to MySQL
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
if (!$conn->select_db(DB_NAME)) {
    $sql = "CREATE DATABASE " . DB_NAME;

    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
        $conn->select_db(DB_NAME);
    } else {
        die("Error creating database: " . $conn->error);
    }
}

// Check if the 'user' table exists
$tableExistsQuery = "SHOW TABLES LIKE 'user'";
$tableExistsResult = $conn->query($tableExistsQuery);

if ($tableExistsResult === FALSE) {
    die("Error checking if 'user' table exists: " . $conn->error);
}

if ($tableExistsResult->num_rows == 0) {
    // Table 'user' does not exist, create it
    $create_user_table = 'CREATE TABLE `user` (
        `first_name` VARCHAR(50) NOT NULL,
        `last_name` VARCHAR(50) NOT NULL,
        `gender` VARCHAR(10) NOT NULL,
        `dob` DATE NOT NULL,
        `email` VARCHAR(100) NOT NULL,
        `password` VARCHAR(50) NOT NULL,
        PRIMARY KEY (`email`)
    ) ENGINE = InnoDB;';

    if ($conn->query($create_user_table) === TRUE) {
        echo "Table 'user' created successfully";
    } else {
        die("Error creating table 'user': " . $conn->error);
    }
} else {
    
}

// Rest of your code for creating the 'emails' table and constraints

// Do not close the database connection here

// Function for checking email existence
function emailExists($email) {
    global $conn;
    $sql = "SELECT email FROM user WHERE email = '" . $email . "'";
    $result = $conn->query($sql);

    if ($result->num_rows != 0) {
        return true;
    } else {
        return false;
    }
}
?>

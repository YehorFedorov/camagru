<?php
include('database.php');
try {
    $db = new PDO($DB_DSN_GLOBAL, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("CREATE DATABASE IF NOT EXISTS camagru");
} catch (PDOException $e) {
    echo "ERROR CREATING DB: " . $e->getMessage() . "\n";
}
try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("DROP TABLE IF EXISTS users");
    $db->query("DROP TABLE IF EXISTS photos");
    $db->query("DROP TABLE IF EXISTS comments");
    $db->query("CREATE TABLE users (
	uid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	email VARCHAR(100) NOT NULL,
	password VARCHAR(255) NOT NULL,
	active INT(1) DEFAULT '0',
	reg_time TIMESTAMP
	)");
    $db->query("CREATE TABLE photos (
	pid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_email VARCHAR(100) NOT NULL,
	image MEDIUMBLOB NOT NULL,
	likes INT(6) DEFAULT '0',
	photo_time TIMESTAMP
	)");
    $db->query("CREATE TABLE comments (
	cid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_email VARCHAR(100) NOT NULL, 
	photo_id INT(6) NOT NULL,
	comment TEXT NOT NULL,
	comment_time TIMESTAMP
	)");
    header("Location: ../index.php");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "csaladfa-v1";

// Create connection for database
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE $dbname";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}
  
$conn->close();

// Create connection for tables
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table PEOPLE
$sql = "CREATE TABLE PEOPLE (
PPLid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
PPLfirstname VARCHAR(30) NOT NULL,
PPLlastname VARCHAR(30) NOT NULL,
PPLdateborn DATE,
PPLplaceborn VARCHAR(30),
PPLdatedeath DATE,
PPLplacedeath VARCHAR(30),
PPLdesc TEXT
)";
if ($conn->query($sql) === TRUE) {
  echo "Table PEOPLE created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table PICTURE
$sql = "CREATE TABLE PICTURE (
PICid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
PICurl VARCHAR(30) TEXT,
PICperson VARCHAR(30) NOT NULL,
PICpersonloc VARCHAR(30),
FOREIGN KEY (PICperson) REFERENCE PEOPLE(PPLid)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table PICTURE created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table EVENTTYPE
$sql = "CREATE TABLE EVENTTYPE (
EVTYPEid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVTYPEname VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTTYPE created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table EVENTMARRIAGE
$sql = "CREATE TABLE EVENTMARRIAGE(
EVMARid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVMARhsuband VARCHAR(30) NOT NULL,
EVMARwife VARCHAR(30) NOT NULL,
EVMARstart DATE,
EVMARend DATE,
FOREIGN KEY (EVMARhusband) REFERENCE PEOPELE (PPLid),
FOREIGN KEY (EVMARwife) REFERENCE PEOPELE (PPLid)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTMARRIAGE created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table EVENTCHILD
$sql = "CREATE TABLE EVENTCHILD(
EVCHILDid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVCHILDfather VARCHAR(30),
EVCHILDmother VARCHAR(30) NOT NULL,
EVCHILDchild VARCHAR(30) NOT NULL,
FOREIGN KEY (EVCHILDfather) REFERENCE PEOPELE (PPLid),
FOREIGN KEY (EVCHILDmother) REFERENCE PEOPELE (PPLid),
FOREIGN KEY (EVCHILDchild) REFERENCE PEOPELE (PPLid)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTCHILD created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table EVENTOTHER
$sql = "CREATE TABLE EVENTOTHER (
EVOTHid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVOTHtype VARCHAR(30) NOT NULL,
EVOTHperson VARCHAR(30) NOT NULL,
EVOTHdate DATE,
EVOTHdesc TEXT,
FOREIGN KEY (EVOTHtype) EVENTTYPE (EVTYPEid),
FOREIGN KEY (EVOTHperson) REFERENCE PEOPELE (PPLid),
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTOTHER created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

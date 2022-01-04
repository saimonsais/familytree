<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

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
$sql = "CREATE TABLE people (
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
$sql = "CREATE TABLE picture (
PICid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
PICurl VARCHAR(30),
PIClocation VARCHAR(30),
PICdate DATE,
PICdesc TEXT
)";
if ($conn->query($sql) === TRUE) {
  echo "Table PICTURE created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table PICTUREPEOPLE
$sql = "CREATE TABLE picturepeople (
  PICPPLid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  PICPPLpicture INT(6) UNSIGNED NOT NULL,
  PICPPLperson INT(6) UNSIGNED NOT NULL,
  PICPPLpersonloc VARCHAR(30) NOT NULL,  
  FOREIGN KEY(PICPPLpicture) REFERENCES picture(PICid),
  FOREIGN KEY(PICPPLperson) REFERENCES people(PPLid)
  )";
  if ($conn->query($sql) === TRUE) {
    echo "Table PICTUREPEOPLE created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }

// sql to create table EVENTTYPE
$sql = "CREATE TABLE eventtype (
EVTYPEid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVTYPEname VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTTYPE created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table EVENTMARRIAGE
$sql = "CREATE TABLE eventmarriage(
EVMARid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVMARhusband INT(6) UNSIGNED NOT NULL,
EVMARwife INT(6) UNSIGNED NOT NULL,
EVMARstart DATE,
EVMARend DATE,
FOREIGN KEY(EVMARhusband) REFERENCES people(PPLid),
FOREIGN KEY(EVMARwife) REFERENCES people(PPLid)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTMARRIAGE created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table EVENTCHILD
$sql = "CREATE TABLE eventchild(
EVCHILDid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVCHILDfather INT(6) UNSIGNED,
EVCHILDmother INT(6) UNSIGNED NOT NULL,
EVCHILDchild INT(6) UNSIGNED NOT NULL,
FOREIGN KEY(EVCHILDfather) REFERENCES people(PPLid),
FOREIGN KEY(EVCHILDmother) REFERENCES people(PPLid),
FOREIGN KEY(EVCHILDchild) REFERENCES people(PPLid)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTCHILD created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table EVENTOTHER
$sql = "CREATE TABLE eventother (
EVOTHid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
EVOTHtype INT(6) UNSIGNED NOT NULL,
EVOTHperson INT(6) UNSIGNED NOT NULL,
EVOTHdate DATE,
EVOTHdesc TEXT,
FOREIGN KEY (EVOTHtype) REFERENCES eventtype(EVTYPEid),
FOREIGN KEY (EVOTHperson) REFERENCES people(PPLid)
)";
if ($conn->query($sql) === TRUE) {
  echo "Table EVENTOTHER created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

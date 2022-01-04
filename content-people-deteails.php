<?php
unset($personid);
unset($resultperson);
if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
  $personid = $_POST['PPLid'];
  }

$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) 
    {
    die("Connection failed: " . $conn->connect_error);
    }
$sqlperson = "SELECT
* 
FROM people 
WHERE PPLid = {$personid}";
$resultperson = $conn->query($sqlperson);
$person = $resultperson->fetch_assoc();

$sqlmarriages = "SELECT 
basic.EVMARstart,
basic.EVMARend,
basic.EVMARhusband AS ferj_id,
ferj.PPLfirstname AS ferj_fn,
ferj.PPLlastname AS ferj_ln,
basic.EVMARwife AS feleseg_id,
feleseg.PPLfirstname AS feleseg_fn,
feleseg.PPLlastname AS feleseg_ln
FROM eventmarriage as basic
JOIN people as ferj on basic.EVMARhusband = ferj.PPLid
JOIN people as feleseg on basic.EVMARwife = feleseg.PPLid
WHERE basic.EVMARhusband = 1 or basic.EVMARwife=1";
$resultmarriages = $conn->query($sqlmarriages);

$sqlparents = "SELECT 
gyerek.PPLfirstname AS gyerek_fn,
gyerek.PPLlastname AS gyerek_ln,
anya.PPLfirstname AS anya_fn,
anya.PPLlastname AS anya_ln,
apa.PPLfirstname AS apa_fn,
apa.PPLlastname AS apa_ln
FROM people as gyerek
JOIN eventchild on gyerek.PPLid = eventchild.EVCHILDchild
JOIN people as anya on anya.PPLid = eventchild.EVCHILDmother
JOIN people as apa on apa.PPLid = eventchild.EVCHILDfather
WHERE eventchild.EVCHILDchild = 3";
$resultparents = $conn->query($sqlparents);

$sqlchildren = "SELECT 
people.PPLfirstname,
people.PPLlastname
FROM people
LEFT JOIN eventchild
ON eventchild.EVCHILDchild = people.PPLid
WHERE eventchild.EVCHILDfather=1 OR eventchild.EVCHILDmother=1";
$resultchildren = $conn->query($sqlmasqlchildrenrriages);


$sqleventother = "SELECT
eventother.*,
eventtype.EVTYPEname
FROM eventother
JOIN eventtype on eventother.EVOTHtype=eventtype.EVTYPEid
JOIN people on eventother.EVOTHperson=people.PPLid
WHERE people.PPLid = 3";
$resulteventother = $conn->query($sqleventother)
$conn->close();
?>



<h1><?php echo $person["PPLlastname"];?> <?php echo $person["PPLfirstname"];?></h1>
<h2>Alap adatok</h2>

<form action="" method="post">
  <label for="PPLlastname">Családnév</label></br>
  <input type="text" id="PPLlastname" name="PPLlastname" value="<?php echo $person["PPLlastname"];?>"></br>

  <label for="PPLlastname">Keresztnév</label></br>
  <input type="text" id="PPLfirstname" name="PPLfirstname" value="<?php echo $person["PPLfirstname"];?>"></br>

  <label for="PPLdateborn">Születés dátum:</label></br>
  <input type="date" id="PPLdateborn" name="PPLdateborn" value="<?php echo $person["PPLdateborn"];?>"></br>

  <label for="PPLplaceborn">Születés helye:</label></br>
  <input type="text" id="PPLplaceborn" name="PPLplaceborn" value="<?php echo $person["PPLplaceborn"];?>"></br>

  <label for="PPLdatedeath">Halál dátum:</label></br>
  <input type="date" id="PPLdatedeath" name="PPLdatedeath" value="<?php echo $person["PPLdatedeath"];?>"></br>

  <label for="PPLplacedeath">Halál helye:</label></br>
  <input type="text" id="PPLplacedeath" name="PPLplacedeath" value="<?php echo $person["PPLplacedeath"];?>"></br>

  <h2>Leírás</h2>

  <label for="PPLdesc">Leírás</label></br>
  <textarea id="PPLdesc" name="PPLdesc" rows="4" cols="50">
  <?php echo $person["PPLdesc"];?>
  </textarea>

  <h2>Házasság</h2>
  <?php
  while($row = $resultmarriages->fetch_assoc())
    {}
  ?>
  <h2>Szülők</h2>
  <?php
  while($row = $resultparents->fetch_assoc())
    {}
  ?>
  <h2>Gyermekek</h2>
  <?php
  while($row = $resultchildren->fetch_assoc())
    {}
  ?>
  <h2>Egyéb események</h2>
  <?php
  while($row = $resulteventother->fetch_assoc())
    {}
  ?>

    <input type="submit" value="Mentés" name="submitperson">
</form>
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
basic.EVMARid AS mariage_id,
basic.EVMARstart AS mariage_start,
basic.EVMARend AS mariage_end,
basic.EVMARhusband AS ferj_id,
ferj.PPLfirstname AS ferj_fn,
ferj.PPLlastname AS ferj_ln,
basic.EVMARwife AS feleseg_id,
feleseg.PPLfirstname AS feleseg_fn,
feleseg.PPLlastname AS feleseg_ln
FROM eventmarriage as basic
JOIN people as ferj on basic.EVMARhusband = ferj.PPLid
JOIN people as feleseg on basic.EVMARwife = feleseg.PPLid
WHERE basic.EVMARhusband ={$personid} or basic.EVMARwife={$personid}";
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
WHERE eventchild.EVCHILDchild = {$personid}";
$resultparents = $conn->query($sqlparents);

$sqlchildren = "SELECT 
basic.EVCHILDid AS child_id,
gyerek.PPLfirstname AS child_fn,
gyerek.PPLlastname AS child_ln,
anya.PPLfirstname AS child_anya_fn,
anya.PPLlastname AS child_anya_ln,
apa.PPLfirstname AS child_apa_fn,
apa.PPLlastname AS child_apa_ln
FROM eventchild as basic
JOIN people gyerek on basic.EVCHILDchild = gyerek.PPLid
JOIN people anya on basic.EVCHILDmother = anya.PPLid
JOIN people apa on basic.EVCHILDfather = apa.PPLid
WHERE basic.EVCHILDfather ={$personid} oR basic.EVCHILDmother = {$personid}";
$resultchildren = $conn->query($sqlchildren);


$sqleventother = "SELECT
eventother.EVOTHid AS event_id,
eventother.EVOTHdate AS event_date,
eventtype.EVTYPEname AS event_type,
eventother.EVOTHdesc AS event_desc
FROM eventother
JOIN eventtype on eventother.EVOTHtype=eventtype.EVTYPEid
JOIN people on eventother.EVOTHperson=people.PPLid
WHERE people.PPLid = {$personid}";
$resulteventother = $conn->query($sqleventother);
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
  <input type="submit" value="Mentés" name="submitperson">
</form>

<h2>Házasság</h2>
<table id="members" class="members">
  <tr>
    <th>Házasság kedete</th>
    <th>Házasság vége</th>
    <th>Férj</th>
    <th>Feleség</th>
    <th>Töröl</th>
  </tr>
  <?php
  while($row = $resultmarriages->fetch_assoc())
    {  
    echo '<tr>';
    echo '<td>'.$row["mariage_start"].'</td>';
    echo '<td>'.$row["mariage_end"].'</td>';
    //echo '<td>'.$row["ferj_id"].'</td>';
    echo '<td>'.$row["ferj_fn"].' '.$row["ferj_ln"].'</td>';
    //echo '<td>'.$row["feleseg_id"].'</td>';
    echo '<td>'.$row["feleseg_fn"].' '.$row["feleseg_ln"].'</td>';
    echo '<td>
            <form action="'.$url_rest.'" method="post">
            <input type="hidden" id="mariage_id" name="mariage_id" value="'.$row["mariage_id"].'">
            <input type="submit" value="Töröl" name="deletemarriage">
            </form>
          </td>';
    echo '</tr>';
    }
  ?>
</table>
<h2>Szülők</h2>
<table id="members" class="members">
  <tr>
    <th>Anya</th>
    <th>Apa</th>
    <th>Töröl</th>
  </tr>
  <?php
  while($row = $resultparents->fetch_assoc())
    {
    echo '<tr>';
    echo '<td>'.$row["anya_ln"].' '.$row["anya_fn"].'</td>';
    echo '<td>'.$row["apa_ln"].' '.$row["apa_fn"].'</td>';
    echo '<td>..</td>';
    echo '</tr>';
    }
  ?>
</table>
<h2>Gyermekek</h2>
<table id="members" class="members">
  <tr>
    <th>Gyermek</th>
    <th>Anya</th>
    <th>Apa</th>
    <th>Töröl</th>
  </tr>
  <?php
  while($row = $resultchildren->fetch_assoc())
    {
      echo '<tr>';
      echo '<td>'.$row["child_ln"].' '.$row["child_fn"].'</td>';
      echo '<td>'.$row["child_anya_ln"].' '.$row["child_anya_fn"].'</td>';
      echo '<td>'.$row["child_apa_ln"].' '.$row["child_apa_fn"].'</td>';
      echo '<td>..</td>';
    echo '</tr>';
    }
  ?>
</table>
<h2>Egyéb események</h2>
<table id="members" class="members">
  <tr>
    <th>Esemény ideje</th>
    <th>Esemény típusa</th>
    <th>Esemény leírása</th>
    <th>Töröl</th>
  </tr>
  <?php
  while($row = $resulteventother->fetch_assoc())
    {
    echo '<tr>';
    echo '<td>'.$row["event_date"].'</td>';
    echo '<td>'.$row["event_type"].'</td>';
    echo '<td>'.$row["event_desc"].'</td>';
    echo '<td><form action="'.$url_rest.'" method="post">
    <input type="hidden" id="event_id" name="event_id" value="'.$row["event_id"].'">
    <input type="submit" value="Töröl" name="deleteevent">
    </form></td>';
    echo '</tr>';
  }
  ?>
</table>


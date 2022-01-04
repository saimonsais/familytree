<h2>Csaladtagok</h2>
        <table id="members" class="members">
            <tr>
              <th>Csaladnév</th>
              <th>Keresztnév</th>
              <th>Születésnap</th>
              <th>Édesanyja</th>
              <th>Édesapja</th>
              <th>Kijelöl</th>
            </tr>

<?php
$conn = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) 
    {
    die("Connection failed: " . $conn->connect_error);
    }
$sqlpeople = "SELECT 
gyerek.PPLid AS gyerek_id,
gyerek.PPLfirstname AS gyerek_fn,
gyerek.PPLlastname AS gyerek_ln,
gyerek.PPLdateborn AS gyerek_szn,
anya.PPLfirstname AS anya_fn,
anya.PPLlastname AS anya_ln,
apa.PPLfirstname AS apa_fn,
apa.PPLlastname AS apa_ln
FROM people as gyerek
LEfT JOIN eventchild on gyerek.PPLid = eventchild.EVCHILDchild
LEfT JOIN people as anya on anya.PPLid = eventchild.EVCHILDmother
LEfT JOIN people as apa on apa.PPLid = eventchild.EVCHILDfather";
$resultpeople = $conn->query($sqlpeople);

$conn->close();

while($row = $resultpeople->fetch_assoc())
    {
    echo '<tr>';
    echo '<td>'.$row["gyerek_ln"].'</td>';
    echo '<td>'.$row["gyerek_fn"].'</td>';
    echo '<td>'.$row["gyerek_szn"].'</td>';
    echo '<td>'.$row["anya_ln"].' '.$row["anya_fn"].'</td>';
    echo '<td>'.$row["apa_ln"].' '.$row["apa_fn"].'</td>';
    echo '<td>
            <form action="'.$url_rest.'" method="post">
            <input type="hidden" id="PPLid" name="PPLid" value="'.$row["gyerek_id"].'">
            <input type="submit" value="Mutasd" name="selectperson">
            </form>
        </td>';

    echo '</tr>';
    }
?>
</table>
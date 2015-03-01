<?php

$username="root";
$password="bananapi";
$database="bdc";

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("points");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the point table
if(isset($_GET['id'])){

	$query = 'SELECT latitude,longitude FROM kilometre WHERE id_trajet='.$_GET['id'];
}
else{
	$query = "SELECT latitude,longitude FROM kilometre k join Trajet t on t.id_trajet = k.id_trajet where k.id_trajet = (select MAX(t.id_trajet) FROM Trajet)";
}

$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  $node = $dom->createElement("point");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("lat", $row['latitude']);
  $newnode->setAttribute("lng", $row['longitude']);
}

echo $dom->saveXML();

?>


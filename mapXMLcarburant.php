<?php

$username="root";
$password="bananapi";
$database="bdc";

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("essences");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "SELECT prixlitre, kilometre_cumule_essence, latitude, longitude, date FROM kilometre WHERE essence = 1";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  $node = $dom->createElement("essence");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("kilometre",$row['kilometre_cumule_essence']);
  $newnode->setAttribute("prixlitre", $row['prixlitre']);
  $newnode->setAttribute("lng", $row['longitude']);
  $newnode->setAttribute("lat", $row['latitude']);
  $newnode->setAttribute("date", $row['date']);
}

echo $dom->saveXML();

?>


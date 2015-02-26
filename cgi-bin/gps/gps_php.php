#!/usr/bin/php
<?
function get_distance_m($lat1, $lng1, $lat2, $lng2) {
  $earth_radius = 6378137;  
  $rlo1 = deg2rad($lng1);
  $rla1 = deg2rad($lat1);
  $rlo2 = deg2rad($lng2);
  $rla2 = deg2rad($lat2);
  $dlo = ($rlo2 - $rlo1) / 2;
  $dla = ($rla2 - $rla1) / 2;
  $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
  $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
  return ($earth_radius * $d);
}
echo round(get_distance_m($argv[1], $argv[2], $argv[3], $argv[4]) / 1000, 3);
?>


<?php
session_start();
include 'dbinfo.php';

$allReservations = $_SESSION['all_reservations'];
$rowNumber = 0;
foreach ($allReservations as $reserve) {
	$string = str_replace(' ', '', $reserve[10]);
	if ($_POST[$string]) {
		unset($allReservations[intval($rowNumber)]);
		$allReservations = array_values($allReservations);
	}
	$rowNumber++;
}


$_SESSION['all_reservations'] = $allReservations;

echo "<script type=\"text/javascript\">";
echo "window.top.location=\"./MakeReservation3.php\"";
echo "</script>";

?>

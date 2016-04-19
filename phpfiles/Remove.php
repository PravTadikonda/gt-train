<?php
session_start();
include 'dbinfo.php';

echo "I'M GONNA REMOVE</br></br>";
    //remove the correct one
    //save train number of just removed

echo "OLD LIST:";
$allReservations = $_SESSION['all_reservations'];
$rowNumber = 0;
foreach ($allReservations as $reserve) {
	echo "</br>";
	foreach ($reserve as $r) {
		echo "$r, ";
	}
	$string = str_replace(' ', '', $reserve[10]);
	if ($_POST[$string]) {
		echo "HEREEEEEE";
		$replacement = array(13 => "1");
		$reserve2 = array_replace($reserve, $replacement);
		$replacement2 = array(intval($rowNumber) => $reserve2);
		$allReservations = array_replace($allReservations, $replacement2);
	}
	$rowNumber++;
}

echo "</br></br>NEW LIST:";
foreach ($allReservations as $reserve) {
	echo "</br>";
	foreach ($reserve as $r) {
		echo "$r, ";
	}
	$string = str_replace(' ', '', $reserve[10]);
	if ($_POST[$string]) {
		echo "HEREEEEEE";
	}
}

$_SESSION['all_reservations'] = $allReservations;

echo "<a href=\"./MakeReservation3.php\"><button type=\"button\">Back</button></a>";
    // echo "<script type=\"text/javascript\">";
    // echo "window.top.location=\"./MakeReservation3.php\"";
    // echo "</script>";

?>

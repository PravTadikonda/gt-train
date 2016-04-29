<?php
session_start();
include 'dbinfo.php';
?>


<html>
<title>GT Train</title>

<head>
  <link rel="stylesheet" href="style.css">
</head>

<body >
<center> 
<h1>GEORGIA TECH TRAIN</h1>

<a href="./ChooseFuncCust.php"><img src="buzz.png" width="128" height="128"></a>

<b><p class = "title"> UPDATE RESERVATION</p></b>

<?php

$trainNum = $_SESSION['trainNum'];
$departTime = $_SESSION['departTime'];
$arriveTime = $_SESSION['arriveTime'];
$departLocation = $_SESSION['departLoc'];
$arriveLocation = $_SESSION['arriveLoc'];
$class = $_SESSION['class'];
$price = $_SESSION['price'];
$totalCost = $_SESSION['totalCost'];
$numBags = $_SESSION['numBags'];
$passangerName = $_SESSION['passanger_name'];
$month = $_SESSION['selectMonth'];
$day = $_SESSION['selectDay'];
$departDay = $_SESSION['departDay'];

date_default_timezone_set('America/New_York');
mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");
if($departTime > $arriveTime) {
	$sql = "SELECT hour(timediff(\"-24:00:00\", timediff(\"$arriveTime\", \"$departTime\"))), minute(timediff(\"-24:00:00\", timediff(\"$arriveTime\", \"$departTime\")))";
} else {
	$sql = "SELECT hour(timediff(\"$departTime\", \"$arriveTime\")), minute(timediff(\"$departTime\", \"$arriveTime\"))";	
}
$result = mysql_query($sql) or die(mysql_error());
$difference = mysql_fetch_array($result);
$hourDiff = $difference[0];
$minDiff = $difference[1];

$arrivalTimeFormat = DATE("g:iA", strtotime("$arriveTime"));
$departTimeFormat = DATE("g:iA", strtotime("$departTime"));

echo "Current Train Ticket";
echo "<table border=\"1\" bordercolor=\"black\">";
    echo "<tr>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Duration</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Departs From</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Arrives At</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Class</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Price</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Number of Baggages</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Passanger Name</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$trainNum</td>";
        echo "<td bgcolor=\"#e6f3ff\">$month $day $departTimeFormat - $arrivalTimeFormat</br>$hourDiff hrs $minDiff mins</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$departLocation</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$arriveLocation</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$class</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$$price</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$numBags</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$passangerName</td>";
    echo "</tr>";
echo "</table>";


echo "<form action=\"\" method=\"POST\">";
echo "<table>";
	echo "<tr>";
		echo "<td><font size=\"4\"/>New Departure Date: </td>";
		echo "<td><input type=\"date\" name=\"newDepartDate\"/></td>";
		echo "<td><input class=\"button\" type=\"submit\" name=\"search\" value=\"Search\"/></td>";
	echo "</tr>";
echo "</table>";
echo "</form>";

if(isset($_POST['newDepartDate'])) {
	$newDepartDate = $_POST['newDepartDate'];
	$_SESSION['newDepartDate'] = $newDepartDate;
	$totalCost = $_SESSION['totalCost'];
	$monthDay = date("F jS", strtotime($newDepartDate));
	$samePage = $_SESSION['samePage'];

	$sql = "SELECT CURDATE()";
    $result = mysql_query($sql) or die(mysql_error());
    $today = mysql_fetch_array($result)[0];

    if($today > $newDepartDate) {
        echo "<font color=\"red\">";
        echo "You can't pick a date in the past";
        echo "</font>";
    } else {
    	echo "Updated Train Ticket";
		echo "<table border=\"1\" bordercolor=\"black\">";
		    echo "<tr>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Duration</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Departs From</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Arrives At</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Class</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Price</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Number of Baggages</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Passanger Name</td>";
		    echo "</tr>";
		    echo "<tr>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/>$trainNum</td>";
		        echo "<td bgcolor=\"#e6f3ff\">$monthDay $departTimeFormat - $arrivalTimeFormat</br>$hourDiff hrs $minDiff mins</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/>$departLocation</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/>$arriveLocation</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/>$class</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/>$$price</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/>$numBags</td>";
		        echo "<td bgcolor=\"#e6f3ff\"><center/>$passangerName</td>";
		    echo "</tr>";
		echo "</table>";

		$sql2 = "SELECT Change_Fee FROM SystemInfo";
		$result2 = mysql_query($sql2) or die(mysql_error());
		$changeFee = mysql_fetch_array($result2)[0];
		echo "</br>";
		echo "Change Fee: <input value=\"$$changeFee\" maxlength=\"20\"/>";
		
		if(!$samePage) {
			$totalCost = $totalCost + $changeFee;
			$_SESSION['totalCost'] = $totalCost;
			$_SESSION['samePage'] = True;
		}
		$totalCost = number_format($totalCost, 2, '.', ',');
			
		echo "<form action=\"\" method=\"POST\">";
		echo "</br>";
		echo "Updated Total Cost: <input value=\"$$totalCost\" maxlength=\"20\"/>";
		echo "</br></br>";
	    echo "<a href=\"./UpdateReservation.php\"><button type=\"button\">Back</button></a>";
		echo "<input class=\"button\" type=\"submit\" name=\"submit\" value=\"Submit\"/>";
		echo "</form>";
    }
}

if(isset($_POST['submit'])) {
	$newDepartDate = $_SESSION['newDepartDate'];
	$totalCost = $_SESSION['totalCost'];
	$reservationID = $_SESSION['reservationID'];
	$trainNum = $_SESSION['trainNum'];
	$sql3 = "UPDATE Reserves SET Total_Cost=\"$totalCost\", Departure_Date=\"$newDepartDate\"
			WHERE Reservation_ID=\"$reservationID\" AND Train_Number=\"$trainNum\"";
	$result3 = mysql_query($sql3) or die(mysql_error());

	echo "<script type=\"text/javascript\">";
	echo "window.top.location=\"./ChooseFuncCust.php\"";
	echo "</script>";
}
?>

</center>
</body>
</html>
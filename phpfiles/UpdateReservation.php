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

<form action="" method="POST"> 
<b><p class = "title"> UPDATE RESERVATION</p></b>

<table>
	<tr>
		<td><font size="4"/>Reservation ID:</td>
		<td><input name="reservationID" maxlength="20"/></td>
	</tr>
</table>

<p>
	<input class="button" type="submit" name="search" value="Search"/>
</p>
</form> 

<br>

<?php

if(isset($_POST['reservationID'])) {
	$reservationID = $_POST['reservationID'];
	$_SESSION['reservationID'] = $reservationID;
	$user = $_SESSION['userID'];
	$_SESSION['samePage'] = False;
	
	date_default_timezone_set('America/New_York');
	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");


	if (empty($reservationID) and $reservationID !== "00000") {
		echo "<font color=\"red\">";
		echo "Put in a reservation ID";
		echo "</font>";
	} else {
		$sql = "CREATE or REPLACE VIEW Departing as (SELECT Station.location as Depart, Stop.departure_time, Reserves.Train_Number
				FROM Reserves JOIN Reservation NATURAL JOIN Train_Route natural join Stop natural join Station
				WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND  Reserves.Reservation_ID = \"$reservationID\"
				AND Reservation.Cust_User = \"$user\" AND Train_Route.train_number = Reserves.train_number
				AND (Station.location=reserves.departs_from) AND Departure_Date > CURDATE() order by Reserves.train_number)";
		mysql_query($sql) or die("The reservation ID does not exist");

		$sql2 = "SELECT Station.location as Arrive, Depart, departing.departure_time, Stop.arrival_time, Reserves.Train_Number,  
					Departs_From, Arrives_At, Class, TRUNCATE(Train_Route.First_Class_Price, 2) as 1st, 
					TRUNCATE(Train_Route.Second_Class_Price, 2) as 2nd, TRUNCATE(Total_Cost, 2) as Total_Cost, Number_Baggages, 
					Passanger_Name, Day(Reserves.Departure_Date) as Day, Monthname(Reserves.Departure_Date) as Month, Departure_Date 
				FROM Reserves JOIN Reservation NATURAL JOIN Train_Route natural join Stop natural join Station JOIN Departing  
				WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND  Reserves.Reservation_ID = \"$reservationID\"   
				AND Reservation.Cust_User = \"$user\" AND Train_Route.train_number = Reserves.train_number  
				AND Departing.Train_Number=Reserves.Train_Number AND Station.location=reserves.arrives_at  
				AND Departure_Date > CURDATE() 
				ORDER BY Reserves.train_number";
		$result2 = mysql_query($sql2) or die(mysql_error());

		$sql4 = "SELECT Is_Cancelled FROM Reserves JOIN Reservation NATURAL JOIN Train_Route 
				WHERE Reserves.Reservation_ID = Reservation.Reservation_ID 
				AND Reserves.Reservation_ID = \"$reservationID\" AND Is_Cancelled =\"0\"";
		$result4 = mysql_query($sql4) or die(mysql_error());

		$sql3 = "SELECT Reservation_ID from Reservation where Cust_User=\"$user\" and reservation_id=\"$reservationID\"";
		$result3 = mysql_query($sql3) or die(mysql_error());

		if(mysql_num_rows($result3) == 0) {
			echo "<font color=\"red\">";
			echo "This reservation ID does not exist for you";
			echo "</font>";
		} else if(mysql_num_rows($result2) == 0) {
			echo "<font color=\"red\">";
			echo "All dates have passed.";
			echo "</font>";
		} else if(mysql_num_rows($result4) == 0) {
			echo "<font color=\"red\">";
			echo "You have already cancelled all reservations under this ID.";
			echo "</font>";
		} else {
			echo "<form action=\"\" method=\"POST\">";
			echo "<table border=\"1\" bordercolor=\"black\">";
			echo "<tr>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Select</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Duration</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Depart From</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Arrives At</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Class</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Price</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Number of Baggages</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Passanger Name</td>";
			echo "</tr>";
			$rowNum = 1;
			while($row = mysql_fetch_array($result2)) {
		        $sql3 = "SELECT hour(timediff(\"$row[3]\", \"$row[2]\")), minute(timediff(\"$row[3]\", \"$row[2]\"))";
		        $result3 = mysql_query($sql3) or die(mysql_error());
		        $difference = mysql_fetch_array($result3);
		        $hourDiff = $difference[0];
		        $minDiff = $difference[1];

		        $arrivalTimeFormat = DATE("g:iA", strtotime("$row[3]"));
		        $departTimeFormat = DATE("g:iA", strtotime("$row[2]"));

		        if ("$row[Class]" == 1) {
		        	$price = $row[8];
		        } else {
		        	$price = $row[9];
		        }
				echo "<tr>";
					echo "<td bgcolor=\"#e6f3ff\"><center/><input type=\"radio\" name=\"reserve\" value=\"$row[Train_Number]_$row[2]_$row[3]_$row[Departs_From]_$row[Arrives_At]_$row[Class]_$row[Total_Cost]_$row[Number_Baggages]_$row[Passanger_Name]_$row[Month]_$row[Day]_$row[Departure_Date]_$price\"/></td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Train_Number]</td>";
					echo "<td bgcolor=\"#e6f3ff\">$row[Month] $row[Day] $departTimeFormat - $arrivalTimeFormat</br>$hourDiff hrs $minDiff mins</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Departs_From]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Arrives_At]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Class]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$$price</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Number_Baggages]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Passanger_Name]</td>";
				echo "</tr>";
				$rowNum = $rowNum + 1;
			}
			echo "</table>";
			echo "</br><a href=\"./ChooseFuncCust.php\"><button type=\"button\">Back</button></a>";
			echo "<input class=\"button\" type=\"submit\" name=\"next\" value=\"Next\"/>";
			echo "</form>";
		}
	}
}

if(isset($_POST["reserve"])) {
	$reserveNum = $_POST["reserve"];
    $pattern = '/[_]/';

    $trainNum = preg_split($pattern, $reserveNum)[0];
    $departTime = preg_split($pattern, $reserveNum)[1];
    $arriveTime = preg_split($pattern, $reserveNum)[2];
    $departLocation = preg_split($pattern, $reserveNum)[3];
    $arriveLocation = preg_split($pattern, $reserveNum)[4];
    $class = preg_split($pattern, $reserveNum)[5];
    $totalCost = preg_split($pattern, $reserveNum)[6];
    $numBags = preg_split($pattern, $reserveNum)[7];
    $passangerName = preg_split($pattern, $reserveNum)[8];
    $month = preg_split($pattern, $reserveNum)[9];
    $day = preg_split($pattern, $reserveNum)[10]; 
    $departDate = preg_split($pattern, $reserveNum)[11];
    $price = preg_split($pattern, $reserveNum)[12];

    $_SESSION['trainNum'] = $trainNum;
    $_SESSION['departTime'] = $departTime;
    $_SESSION['arriveTime'] = $arriveTime;
    $_SESSION['departLoc'] = $departLocation;
    $_SESSION['arriveLoc'] = $arriveLocation;
    $_SESSION['class'] = $class;
    $_SESSION['price'] = $price;
    $_SESSION['totalCost'] = $totalCost;
    $_SESSION['numBags'] = $numBags;
    $_SESSION['passanger_name'] = $passangerName;
    $_SESSION['selectMonth'] = $month;
    $_SESSION['selectDay'] = $day;
    $_SESSION['departDay'] = $departDay;

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql = "SELECT CURDATE()";
	$result = mysql_query($sql) or die(mysql_error());
	$today = mysql_fetch_array($result)[0];

	$sql = "SELECT TIMESTAMPDIFF(hour, CURDATE(), \"$departDate\")";
	$result = mysql_query($sql) or die(mysql_error());
	$difference = mysql_fetch_array($result)[0];

	if ($difference < 1) {
		echo "<font color=\"red\">";
		echo "You cannot selected reservation";
		echo "</font>";
	} else {
		echo "<script type=\"text/javascript\">";
		echo "window.top.location=\"./UpdateReservation2.php\"";
		echo "</script>";
	}
}
?>

</center>
</body>
</html>
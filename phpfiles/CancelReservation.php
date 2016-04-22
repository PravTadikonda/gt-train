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
<b><p class = "title"> CANCEL RESERVATION</p></b>

<table>
	<tr>
		<td><font size="4"/>Reservation ID:</td>
		<td><input name="reservationID" maxlength="20"/></td>
		<td><input class="button" type="submit" name="login" value="Submit"/></td>
	</tr>
</table>
</form> 

<?php
if(isset($_POST["reservationID"])) {
	$reservationID = $_POST["reservationID"];
	$user = $_SESSION['userID'];
	$_SESSION['reserveID'] = $reservationID;

	$departTime = $_SESSION['depart_time'];
	$arriveTime = $_SESSION['arrive_time'];

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql = "SELECT Departure_Date, Monthname(Departure_Date) as Month, Day(Departure_Date) as Day, Second_Class_Price, First_Class_Price, Reserves.Train_Number, Departs_From, Arrives_At, Class, 
			TRUNCATE(Total_Cost, 2) AS TC, Number_Baggages, Passanger_Name
			FROM Reserves JOIN Reservation NATURAL JOIN Train_Route 
			WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND Reserves.Reservation_ID = \"$reservationID\" 
			AND Reservation.Cust_User = \"$user\" AND Reserves.Train_Number = Train_Route.Train_Number AND Departure_Date > CURDATE()";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql2 = "SELECT Sum(TRUNCATE(Total_Cost, 2)) AS TC FROM Reserves JOIN Reservation NATURAL JOIN Train_Route 
			WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND Reserves.Reservation_ID = \"$reservationID\" 
			AND Reservation.Cust_User = \"$user\" AND Reserves.Train_Number = Train_Route.Train_Number AND Departure_Date > CURDATE()";
	$result2 = mysql_query($sql2) or die(mysql_error());
	$totalSum = mysql_fetch_array($result2)[0];

	$sql3 = "SELECT CURDATE()";
	$result3 = mysql_query($sql3) or die(mysql_error());
	$today = mysql_fetch_array($result3)[0];

	$sql4 = "SELECT Is_Cancelled FROM Reserves JOIN Reservation NATURAL JOIN Train_Route 
			WHERE Reserves.Reservation_ID = Reservation.Reservation_ID 
			AND Reserves.Reservation_ID = \"$reservationID\" AND Is_Cancelled =\"0\"";
	$result4 = mysql_query($sql4) or die(mysql_error());

	if(mysql_num_rows($result) == 0) {
		echo "<font color=\"red\">";
		echo "This reservation ID does not exist for you.";
		echo "</font>";
	} else if(mysql_num_rows($result4) == 0) {
		echo "<font color=\"red\">";
		echo "You have already cancelled all reservations under this ID.";
		echo "</font>";
	} else {
		echo "<table border=\"1\" bordercolor=\"black\">";
		echo "<tr>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Duration</td>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Depart From</td>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Arrives At</td>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Class</td>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Price</td>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Number of Baggages</td>";
			echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Passanger Name</td>";
		echo "</tr>";
		$classNum = 0;
		$earliestDay = 1000000000;
		$earliestDate = 'Nothing';
		$_SESSION['numberOfCancelRows'] = mysql_num_rows($result);
		date_default_timezone_set('America/New_York');

		while($row = mysql_fetch_array($result)) {
			if ("$row[Class]" == 1) { 
				$classNum = "$row[First_Class_Price]"; 
			} else { 
				$classNum = "$row[Second_Class_Price]"; 
			}
			$sql5 = "SELECT TIMESTAMPDIFF(day, CURDATE(), \"$row[Departure_Date]\")";
			$result5 = mysql_query($sql5) or die(mysql_error());
			$difference = mysql_fetch_array($result5)[0];
			if ($difference < $earliestDay and $difference >= 0) {
				$earliestDate = $row["Departure_Date"];
				$earliestDay = $difference;
			}
			$sql6 = "SELECT Arrival_Time FROM reservstation WHERE Train_number=\"$row[Train_Number]\" AND Location=\"$row[Arrives_At]\" ORDER BY train_number";
			$result6 = mysql_query($sql6) or die(mysql_error());
			$arriveTime = mysql_fetch_array($result6)[0];
			$sql7 = "SELECT Departure_Time FROM reservstation WHERE Train_number=\"$row[Train_Number]\" AND Location=\"$row[Departs_From]\" ORDER BY train_number";
			$result7 = mysql_query($sql7) or die(mysql_error());
			$departTime = mysql_fetch_array($result7)[0];


			if ($departTime > $arriveTime) {
	            $sql8 = "SELECT hour(timediff(\"-24:00:00\", timediff(\"$arriveTime\", \"$departTime\"))), minute(timediff(\"-24:00:00\", timediff(\"$arriveTime\", \"$departTime\")))";
	        } else {
	            $sql8 = "SELECT hour(timediff(\"$arriveTime\", \"$departTime\")), minute(timediff(\"$arriveTime\", \"$departTime\"))";
	        }
	        $result8 = mysql_query($sql8) or die(mysql_error());
	        $difference = mysql_fetch_array($result8);
	        $hourDiff = $difference[0];
	        $minDiff = $difference[1];

	        $arrivalTimeFormat = DATE("g:iA", strtotime("$arriveTime"));
	        $departTimeFormat = DATE("g:iA", strtotime("$departTime"));

			echo "<tr>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Train_Number]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Month] $row[Day] $departTimeFormat - $arrivalTimeFormat</br>$hourDiff hrs $minDiff mins</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Departs_From]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Arrives_At]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Class]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$$classNum</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Number_Baggages]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Passanger_Name]</td>";
			echo "</tr>";
		}
		echo "</table>";
		if ($earliestDay < 1) {
			echo " </br></br>";
			echo "<font color=\"red\">";
			echo "You cannot cancel at this time";
			echo "</font>";
			echo " </br></br>";
			echo "<a href=\"./chooseFuncCust.php\"><button type=\"button\">Back</button></a>";
		} else {
			$refundedSum = 0;
			if($earliestDay > 7) {
				$refundedSum = ($totalSum * .8) - 50;
			} else if($earliestDay <= 7 and $earliestDay >= 1) {
				$refundedSum = ($totalSum * .5) - 50;
			}
			if ($refundedSum < 0) {
				$refundedSum = 0;
			}
			$refundedSum = number_format("$refundedSum",2)."";

			$_SESSION['totalKeep'] = $totalSum - $refundedSum;
			$_SESSION['refunded']= $refundedSum;

			echo " </br>";
			echo "<form action=\"\" method=\"POST\">";
			echo "Total Cost of Reservation: <input value=\"$$totalSum\" maxlength=\"20\"/>";
			echo " </br> </br>";
			echo "Date of Cancellation: <input value=\"$today\" maxlength=\"20\"/>";
			echo " </br> </br>";
			echo "Amount to be Refunded: <input value=\"$$refundedSum\" maxlength=\"20\"/>";
			echo " </br> </br>";
			echo "<a href=\"./chooseFuncCust.php\"><button type=\"button\">Back</button></a>";
			echo "<input class=\"button\" type=\"submit\" name=\"cancel\" value=\"Submit\"/>";
		}
		echo "</form>";
	}
}

if(isset($_POST["cancel"])) {
	$totalKeep = $_SESSION['totalKeep'];
	$refundedSum = $_SESSION['refunded'];
	$user = $_SESSION['userID'];
	$reservationID = $_SESSION['reserveID'];
	$numberOfCancelRows = $_SESSION['numberOfCancelRows'];

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	echo "<font color=\"green\">";
	echo "You're reservation has been cancelled and you have been refunded <u>$$refundedSum</u>!";
	echo "</font>";

	$totalKeep = $totalKeep/$numberOfCancelRows;
	$sql6 = "UPDATE Reservation SET Is_Cancelled=\"1\" WHERE Cust_User=\"$user\" AND Reservation_ID=\"$reservationID\"";
	mysql_query($sql6) or die(mysql_error());
	
	$sql7 = "UPDATE Reserves SET Total_Cost=\"$totalKeep\" WHERE Reservation_ID=\"$reservationID\"";
	mysql_query($sql7) or die(mysql_error());

	echo "</br></br>";
	echo "<a href=\"./chooseFuncCust.php\"><button type=\"button\">Back</button></a>";

}
?>
</center>
</body>
</html>
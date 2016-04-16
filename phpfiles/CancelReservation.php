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

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql = "SELECT Second_Class_Price, First_Class_Price, Reserves.Train_Number, Departs_From, Arrives_At, Class, 
			TRUNCATE(Total_Cost, 2) AS TC, Number_Baggages, Passanger_Name
			FROM Reserves JOIN Reservation NATURAL JOIN Train_Route 
			WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND Reserves.Reservation_ID = \"$reservationID\" 
			AND Reservation.Cust_User = \"$user\" AND Reserves.Train_Number = Train_Route.Train_Number";
	$result = mysql_query($sql) or die(mysql_error());
	
	$sql2 = "SELECT Sum(TRUNCATE(Total_Cost, 2)) AS TC FROM Reserves JOIN Reservation NATURAL JOIN Train_Route 
			WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND Reserves.Reservation_ID = \"$reservationID\" 
			AND Reservation.Cust_User = \"$user\" AND Reserves.Train_Number = Train_Route.Train_Number";
	$result2 = mysql_query($sql2) or die(mysql_error());
	$totalSum = mysql_fetch_array($result2)[0];

	$sql3 = "SELECT CURDATE()";
	$result3 = mysql_query($sql3) or die(mysql_error());
	$today = mysql_fetch_array($result3)[0];

	if(mysql_num_rows($result) == 0) {
		echo "<font color=\"red\">";
		echo "This reservation ID does not exist for you.";
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
		while($row = mysql_fetch_array($result)) {
			if ("$row[Class]" == 1) { 
				$classNum = "$row[First_Class_Price]"; 
			} else { 
				$classNum = "$row[Second_Class_Price]"; 
			} 
			echo "<tr>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Train_Number]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Departs_From]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Arrives_At]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Class]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$$classNum</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Number_Baggages]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Passanger_Name]</td>";
			echo "</tr>";
		}
		echo "</table>";

		echo " </br>";
		echo "Total Cost of Reservation: <input value=\"$totalSum\" maxlength=\"20\"/>";
		echo " </br> </br>";
		echo "Date of Cancellation: <input value=\"$today\" maxlength=\"20\"/>";
		echo " </br> </br>";
		echo "Amount to be Refunded: <input value=\"NOTHING\" maxlength=\"20\"/>";
		echo " </br> </br>";
		echo "<a href=\"./chooseFuncCust.php\"><button type=\"button\">Back</button></a>";
		echo "<a href=\"#\"><button type=\"button\">Submit</button></a>";
	}

}
?>
</center>
</body>
</html>
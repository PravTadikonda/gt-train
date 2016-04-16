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
	$user = $_SESSION['userID'];
	
	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	if (empty($reservationID)) {
		echo "<font color=\"red\">";
		echo "Put in a reservation ID";
		echo "</font>";
	} else {
		//when we delete reservation, is the ID gone too?
		$sql = "SELECT  Train_Number, Departs_From, Arrives_At, Class, TRUNCATE(Total_Cost, 2) as Total_Cost, Number_Baggages, Passanger_Name
			FROM Reserves JOIN Reservation WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND 
			Reserves.Reservation_ID = \"$reservationID\" AND Reservation.Cust_User = \"$user\"";
		$result = mysql_query($sql) or die("The reservation ID does not exist");
		$result2 = $result;
		if(mysql_num_rows($result) == 0) {
			echo "<font color=\"red\">";
			echo "This reservation ID does not exist for you.";
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
				echo "<tr>";
					echo "<td bgcolor=\"#e6f3ff\"><center/><input type=\"radio\" name=\"reserve\" value=\"$rowNum\"/></td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Train_Number]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Departs_From]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Arrives_At]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Class]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$$row[Total_Cost]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Number_Baggages]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Passanger_Name]</td>";
				echo "</tr>";
				$rowNum = $rowNum + 1;
			}
			echo "</table>";
			// $reserveNum = $_POST["reserve"];
			// $_SESSION['reserveNum'] = $reserveNum;
			// echo "$reserveNum";
			// print 
			echo "</br><a href=\"./ChooseFuncCust.php\"><button type=\"button\">Back</button></a>";
			echo "<a href=\"./UpdateReservation2.php\"><input class=\"button\" type=\"button\" name=\"next\" value=\"Next\"/></a>";
			// echo "<a href=\"./UpdateReservation2.php\"><input style=\"width:100px;height:25px\" type=\"button\" value=\"Next\"></input></a>";
			// echo "<input type=\"button\" value=\"blah1\" onClick=\"window.location.href = 'UpdateReservation2.php'\">";
			// $_GET["reserve"];
			$reserveNum = $_REQUEST["reserve"];
			$_SESSION['reserveNum'] = $reserveNum;
			echo "$reserveNum";
			echo "</form>";
		}
	}
}


if(isset($_POST["reserve"])) {
	$reserveNum = $_POST["reserve"];

	$_SESSION['reserveNum'] = $reserveNum;
	echo "$reserveNum";

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");
	
	$sql = "SELECT * FROM Reserves JOIN Reservation WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND 
			Reserves.Reservation_ID = \"$reservationID\" AND Reservation.Cust_User = \"$user\"";
	$result = mysql_query($sql) or die("The reservation ID does not exist");
	
	//how to get that row we just selected
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
		// $rowNum = 1;
		// while($row = mysql_fetch_array($result)) {
		// 	if ($rowNum == $reserveNum) {
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Train_Number]</td>";
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Departs_From]</td>";
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Arrives_At]</td>";
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Class]</td>";
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Number_Baggages]</td>";
		// 		echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Passanger_Name]</td>";
		// 	}
		// 	$rowNum = $rowNum + 1;
		// }
	echo "</table>";
	echo "</br>";
	// echo "<td bgcolor=\"#e6f3ff\"><center/>Train</td>";
	// echo "</table>";
	// header("Location:UpdateReservation2.php");

	echo "<form>";
	echo "<table>";
		echo "<tr>";
			echo "<td><font size=\"4\"/>New Departure Date:&nbsp</td>";
			echo "<td><input type=\"date\" name=\"newDepartDate\"/></td>";
			echo "<td><input class=\"button\" type=\"submit\" name=\"search\" value=\"Search\"/></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
}

if(isset($_POST["newDepartDate"],$_POST["search"])) {
	$newDate = $_POST["newDepartDate"];
	echo "$newDate";
	echo "helloooooooo";
}
?>

<!-- <form>
<table>
	<tr>
	
	<td><input type="date" name="newDepartDate"/></td>
	<td><input class="button" type="submit" name="search" value="Search"/></td>
	</tr>
</table>
</form> -->

</center>
</body>
</html>
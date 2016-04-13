<?php
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
	<!-- <a href="#"><button type="button">Search</button></a> -->
	<input class="button" type="submit" name="search" value="Search"/>
</p>
</form> 

<br>

<?php

if(isset($_POST['reservationID'])) {
	$reservationID = $_POST['reservationID'];
	
	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	if (empty($reservationID)) {
		echo "<font color=\"red\">";
		echo "Put in a reservation ID";
		echo "</font>";
	} else {
		//when we delete reservation, is the ID gone too?
		$sql = "SELECT * FROM Reserves WHERE Reservation_ID = \"$reservationID\"";
		$result = mysql_query($sql) or die("The reservation ID does not exist");


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
		while($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><input type=\"radio\" name=\"q1\" value=\"5\"/></td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Train_Number]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Departs_From]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Arrives_At]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Class]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Number_Baggages]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Passanger_Name]</td>";
			echo "</tr>";
		}

		echo "</table>";
		echo "</br><a href=\"./ChooseFuncCust.php\"><button type=\"button\">Back</button></a>";
		echo "<input class=\"button\" type=\"submit\" name=\"search\" value=\"Next\"/>";
	}

				
}

?>
</center>
</body>
</html>
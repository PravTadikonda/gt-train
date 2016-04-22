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
<b><p class = "title">VIEW TRAIN SCHEDULE</p></b>

<table>
	<tr>
		<td><font size="4"/>Train Number:</td>
		<td><input name="trainNum" maxlength="20"/></td>
	</tr>
</table>

<p>
	<a href="./ChooseFuncCust.php"><button type="button">Back</button></a>
	<input class="button" type="submit" name="search" value="Search"/>
</p>
</form> 

<br>

<?php

if(isset($_POST['trainNum'])) {
	$trainNum = $_POST['trainNum'];

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");
	date_default_timezone_set('America/New_York');

	if (empty($trainNum)) {
		echo "<font color=\"red\">";
		echo "Put in a train number";
		echo "</font>";
	} else {
		$sql = "SELECT Train_Number, Arrival_Time, Departure_Time, Location, Station.Name 
				FROM (Stop JOIN Station) WHERE Train_Number=\"$trainNum\" AND Stop.Name = Station.Name ORDER BY Departure_Time";
		$result = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($result) == 0) {
			echo "<font color=\"red\">";
			echo "This train number does not have a schedule";
			echo "</font>";
		} else {
			echo "<table border=\"1\" bordercolor=\"black\">";
			echo "<tr>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Arrival Time</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Departure Time</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Station</td>";
			echo "</tr>";
			$prevTrainNum = "";
			$rowNum = 0;
			$colLength = mysql_num_rows($result);
			while($row = mysql_fetch_array($result)) {
				$arrivalTimeFormat = DATE("g:i A", strtotime("$row[Arrival_Time]"));
				$departTimeFormat = DATE("g:i A", strtotime("$row[Departure_Time]"));
				
				echo "<tr>";
					if ($row["Train_Number"] !== "$prevTrainNum") {
						echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Train_Number]</td>";
					} else {
						echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
					}
					if ($rowNum !== 0) {
						echo "<td bgcolor=\"#e6f3ff\"><center/>$arrivalTimeFormat</td>";
					} else {
						echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
					}
					if ($rowNum !== $colLength - 1) {
						echo "<td bgcolor=\"#e6f3ff\"><center/>$departTimeFormat</td>";
					} else {
						echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
					}
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Location]($row[Name])</td>";
				echo "</tr>";
				$prevTrainNum = $row["Train_Number"];
				$rowNum++;
			}
		}
		echo "</table>";
	}
}

?>
</center>
</body>
</html>
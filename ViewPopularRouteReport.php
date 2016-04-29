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

<a href="./ChooseFuncMang.php"><img src="buzz.png" width="128" height="128"></a>

<b><p class = "title">VIEW POPULAR ROUTE REPORT</p></b>

<?php
	echo "<table border=\"1\" bordercolor=\"black\">";
	echo "<tr>";
		echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Month</td>";
		echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
		echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Number of Reservations</td>";
	echo "</tr>";

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql = "SELECT MONTHNAME(Departure_Date), train_number, count(month(departure_date)), MONTH(Departure_Date) AS MonthDate
			FROM (SELECT Train_Number, Departure_Date 
				FROM Train_Route NATURAL JOIN Reserves NATURAL JOIN Reservation NATURAL JOIN Customer 
				WHERE Departure_Date BETWEEN Date_Sub(DATE_FORMAT(NOW() ,'%Y-%m-01'), INTERVAL 2 MONTH) AND CURDATE() 
				AND Is_Cancelled = \"0\") AS A
			GROUP BY MONTHNAME(Departure_Date), Train_Number, MonthDate
			ORDER BY MonthDate";

	$result = mysql_query($sql) or die(mysql_error());

	if (mysql_num_rows($result) == 0) {
		echo "<font color=\"red\">";
		echo "There are no reservations for the past 3 months";
		echo "</font>";
	} else {
		$prevMonth = "";
		while($row = mysql_fetch_array($result)) {
			echo "<tr>";
			if($row[0] == $prevMonth) {
				echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
			} else {
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[0]</td>";
			}
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[1]</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/>$row[2]</td>";
			echo "</tr>";
			$prevMonth = $row[0];
		}
		echo "</table>";
	}
?>

<p>
	<a href="./ChooseFuncMang.php"><button type="button">Back</button></a>
</p>

</center>
</body>
</html>
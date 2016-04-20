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

<img src="buzz.png" width="128" height="128">

<form action=\"\" method=\"POST\" id = "mainBlock"> 
<b><p class = "title">VIEW REVENUE REPORT</p></b>
<?php
	echo "<table border=\"1\" bordercolor=\"black\">";
	echo "<tr>";
		echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Month</td>";
		echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Revenue</td>";
	echo "</tr>";

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql = "SELECT MONTHNAME(Departure_Date) AS Month, TRUNCATE(SUM(Total_Cost), 2) AS Revenue, MONTH(Departure_Date) AS MonthDate
			FROM (SELECT Total_Cost, Departure_Date FROM Reserves
				WHERE Departure_Date BETWEEN Date_Sub(DATE_FORMAT(NOW() ,'%Y-%m-01'), INTERVAL 2 MONTH) AND CURDATE()) AS a 
			GROUP BY MONTHNAME(Departure_Date), MonthDate
			ORDER BY MonthDate";
	$result = mysql_query($sql) or die(mysql_error());

	if (mysql_num_rows($result) == 0) {
		echo "<font color=\"red\">";
		echo "There are no reservations for the past 3 months";
		echo "</font>";
	} else {
		while($row = mysql_fetch_array($result)) {
			echo "<tr>";
				echo "<td bgcolor=\"#e6f3ff\" style=\"padding-right:2em;\">$row[0]</td>";
				echo "<td bgcolor=\"#e6f3ff\" style=\"padding-right:2em;\">$$row[1]</td>";
			echo "</tr>";	
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

</center>
</body>
</html>
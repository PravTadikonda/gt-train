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
<b><p class = "title">VIEW REVIEWS</p></b>

<table>
	<tr>
		<td><font size="4"/>Train Number:</td>
		<td><input name="trainNumber"/></td>
	</tr>
</table>

<p>
	<input class="button" type="submit" name="submit" value="Search"/>
</p>
</form> 

<br>

<?php

if(isset($_POST['trainNumber'])) {
	$trainNum = $_POST['trainNumber'];

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	if (empty($trainNum)) {
		echo "<font color=\"red\">";
		echo "Put in a train number";
		echo "</font>";
	} else {
		$sql = "SELECT * FROM Review WHERE Train_Number = \"$trainNum\"";
		$result = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($result) == 0) {
			echo "<font color=\"red\">";
			echo "A review for that train number does not exist";
			echo "</font>";
		} else {
			echo "<table border=\"1\" bordercolor=\"black\">";
			echo "<tr>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Rating</td>";
				echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Comment</td>";
			echo "</tr>";
			while($row = mysql_fetch_array($result)) {
				echo "<tr>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Rating]</td>";
					echo "<td bgcolor=\"#e6f3ff\"><center/>$row[Comment]</td>";
				echo "</tr>";
			}
		}
		echo "</table>";
	}
}

?>
</center>
</body>
</html>
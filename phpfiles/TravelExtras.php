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

<a href="./ChooseFuncCust.html"><img src="buzz.png" width="128" height="128"></a>

<form action="" method="POST"> 
<b><p class = "title">TRAVEL EXTRAS & PASSENGER INFO</p></b>
<table>
	<tr>
		<td><font size="4"/>Number of Bags:</td>
		<td><select name="bags">
        	<option value="Nothing">--</option>
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
		</select></td>
	</tr>
	<tr>
		<td><font size="4"/>Passenger Name:</td>
		<td><input name="passangerName"/></td>
	</tr>

</table>

<p>
	<a href="MakeReservation2.php"><button type="button">Back</button></a>
	<input class="button" type="submit" name="submit" value="Next"/>
</p>
</form> 

<br>

<?php

$user = $_SESSION['userID'];

if(isset($_POST["bags"], $_POST["passangerName"])) {
	$bags = $_POST["bags"];
	$passangerName = $_POST["passangerName"];
	$_SESSION['bags']= $bags;
	$_SESSION['passangerName']= $passangerName;

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	if ($bags == 'Nothing' or empty($passangerName)) {
		echo "<font color=\"red\">";
		echo "Some fields are not filled in";
		echo "</font>";
	} else {
		echo "<script type=\"text/javascript\">";
		echo "window.top.location=\"./MakeReservation3.php\"";
  		echo "</script>";
	}
}

?>

</center>
</body>
</html>
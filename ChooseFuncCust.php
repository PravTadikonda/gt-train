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

<img src="buzz.png" width="128" height="128">

<form action=\"\" method=\"POST\" id = "mainBlock"> 
<b><p class = "title"> CHOOSE FUNCTIONALITY</p></b>
<table>
	<tr>
		<td align="center"><a href="./ViewTrainSchedule.php"><font size="4"/>View Train Schedule </a></td>
	</tr>
	<tr>
		<td align="center"><a href="./MakeReservation1.php"><font size="4"/>Make a New Reservation </a></td>
	</tr>
	<tr>
		<td align="center"><a href="./UpdateReservation.php"><font size="4"/>Update a Reservation </a></td>
	</tr>
	<tr>
		<td align="center"><a href="./CancelReservation.php"><font size="4"/>Cancel a Reservation</a></td>
	</tr>
	<tr>
		<td align="center"><a href="./ViewReview.php"><font size="4"/>View Reviews </a></td>
	</tr>
	<tr>
		<td align="center"><a href="./GiveReview.php"><font size="4"/>Give a Review </a></td>
	</tr>
	<tr>
		<td align="center"><a href="./AddSchoolInfo.php"> <font size="4"/>Add School Information (Student Discount)</a></td>
	</tr>
</table>

<p>
	<a href="./loginPage.php"><button type="button">Log Out</button></a>
</p>
</form> 

<br>

<?php

mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

?>

</center>
</body>
</html>
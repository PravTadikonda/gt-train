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

<!-- 
if(isset($_POST["reserve"])) {
	$choice = $_POST["reserve"];

	echo "Current Train Ticket";
	// $sql2 = "SELECT * FROM Reserves JOIN Reservation WHERE Reserves.Reservation_ID = Reservation.Reservation_ID AND 
	// 		Reserves.Reservation_ID = \"$reservationID\" AND Reservation.Cust_User = \"$user\"";
	// $result2 = mysql_query($sql) or die("The reservation ID does not exist");
} -->

<table>
	<tr>
	<td><font size="4"/>New Departure Date:&nbsp</td>
	<td><input type="date" name="newDepartDate"/></td>
	<td><input class="button" type="submit" name="search" value="Search"/></td>
	</tr>
</table>
</form>

<br>

<?php
$reserveNum = $_SESSION["reserveNum_ID"];

if(isset($_POST["newDepartDate"])) {
	$newDate = $_POST["newDepartDate"];
	echo "$newDate</br>$reserveNum";
}
?>

</center>
</body>
</html>
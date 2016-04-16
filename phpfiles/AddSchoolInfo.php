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
<b><p class = "title"> ADD SCHOOL INFO</p></b>

<table>
	<tr>
		<td><font size="4"/>School E-mail Address:</td>
		<td><input name="school" type="email"/></td>
	</tr>
</table>

<p>
	<a href="./ChooseFuncCust.php"><button type="button">Back</button></a>
	<input class="button" type="submit" name="submit" value="Submit"/>
</p>
</form> 

<br>

<?php

$user = $_SESSION['userID'];

if(isset($_POST['school'])) {
	$school = $_POST['school'];

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql5 = "SELECT Is_Student FROM Customer WHERE Cust_User=\"$user\"";
	$result5 = mysql_query($sql5) or die(mysql_error());
	$is_student = mysql_fetch_array($result5)[0];;

	if (empty($school)) {
		echo "<font color=\"red\">";
		echo "Put down an email";
		echo "</font>";
	} else if(!filter_var($school, FILTER_VALIDATE_EMAIL)) {
		echo "<font color=\"red\">";
		echo "Invalid Email";
		echo "</font>";
	} else if (!strpos($school, '.edu')) {
		echo "<font color=\"red\">";
		echo "Not a school email address";
		echo "</font>";
	} else if ($is_student == 1) {
		echo "<font color=\"red\">";
		echo "You already have the discount";
		echo "</font>";
	
	} else {
		//sql & sql2 can be mushed
		$sql = "SELECT Total_Cost FROM Reserves NATURAL JOIN Reservation WHERE Cust_User=\"$user\"";
		$result = mysql_query($sql) or die(mysql_error());
		$sql2 = "SELECT Reservation_ID FROM Reserves NATURAL JOIN Reservation WHERE Cust_User=\"$user\"";
		$result2 = mysql_query($sql2) or die(mysql_error());
		$reservation_id = mysql_fetch_array($result2)[0];
		$sql6 = "SELECT Student_Discount FROM SystemInfo";
		$result6 = mysql_query($sql6) or die(mysql_error());
		$studentDiscount = mysql_fetch_array($result6)[0];
		if (mysql_num_rows($result) !== 0) {
			while($row = mysql_fetch_array($result)) {
				$new_Total_Cost = $row[0] * $studentDiscount;
				$sql3 = "UPDATE Reserves SET Total_Cost=\"$new_Total_Cost\" WHERE Reservation_ID=\"$reservation_id\" AND Total_Cost=\"$row[0]\"";
				mysql_query($sql3) or die(mysql_error());
			}
		}
		$sql4 = "UPDATE Customer SET Is_Student = \"1\" WHERE Cust_User = \"$user\"";
		mysql_query($sql4) or die(mysql_error());
		echo "<font color=\"green\">";
		echo "Congrats! You get a 20% discount";
		echo "</font>";
	}
}

?>

</center>
</body>
</html>
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
<b><p class = "title"> GIVE REVIEW</p></b>
<table>
	<tr>
		<td><font size="4"/>Train Number:</td>
		<td><input name = "trainNum"/></td>
	</tr>
	<tr>
		<td><font size="4"/>Rating:</td>
		<td><select name="rating">
        	<option value="Nothing">--</option>
			<option value="Very Good">Very Good</option>
			<option value="Good">Good</option>
			<option value="Neutral">Neutral</option>
			<option value="Bad">Bad</option>
			<option value="Very Bad">Very Bad</option>
		</select></td>
	</tr>
	<tr>
		<td><font size="4"/>Comment:</td>
		<td><textarea name="comment" rows="4" cols="50"></textarea></td>
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

if(isset($_POST['trainNum'])) {
	$trainNum = $_POST['trainNum'];
	$rating = $_POST['rating'];
	$comment = $_POST['comment'];

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	if(empty($trainNum) or $rating == 'Nothing') {
		echo "<font color=\"red\">";
		echo "Some fields are not filled in";
		echo "</font>";
	} else {
		$sql = "SELECT Train_Number FROM Train_Route WHERE Train_Number = \"$trainNum\"";
		$result = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($result) !== 1) {
			echo "<font color=\"red\">";
			echo "This train number does not exist";
			echo "</font>";
		} else {
			$sql2 = "SELECT * FROM Review";
			$result2 = mysql_query($sql2) or die(mysql_error());
			$reviewNum = mysql_num_rows($result2) + 1;

			$sql3 = "INSERT INTO Review (Review_Num, Comment, Rating, Cust_User, Train_Number) VALUES (\"$reviewNum\", \"$comment\", \"$rating\", \"$user\", \"$trainNum\")";
			mysql_query($sql3) or die(mysql_error());
			echo "<font color=\"green\">";
			echo "Thanks for your review!";
			echo "</font>";
		}
	}
}
?>
</center>
</body>
</html>
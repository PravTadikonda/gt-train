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
<!-- <p font-size = "5"> Your school email ends with .edu</p> -->
<table>
	<tr>
		<td><font size="4"/>School E-mail Address:</td>
		<td><input name="school" type="email"/></td>
	</tr>
</table>

<p>
	<a href="./ChooseFunc.php"><button type="button">Back</button></a>
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
	} else {
		$sql = "UPDATE Customer SET Is_Student = \"1\" WHERE Cust_User = \"$user\"";
		mysql_query($sql) or die(mysql_error());
		echo "<font color=\"green\">";
		echo "Congrats! You get a 20% discount";
		echo "</font>";
	}
}

?>

</center>
</body>
</html>
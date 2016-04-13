<?php
session_start();
include 'dbinfo.php';
?>

<html>
<title>GT Train</title>

<head>
	<link rel="icon" href="demo_icon.png" type="image/png" sizes="16x16">
  	<link rel="stylesheet" href="style.css">
</head>

<body >
<center> 
<h1>GEORGIA TECH TRAIN</h1>

<img src="buzz.png" width="128" height="128">

<form action="" method="POST"> 
<b><p class = "title"> LOGIN PAGE</p></b>
<table>
	<tr>
		<td><font size="4"/>Username:</td>
		<td><input name = "user" maxlength="20"/></td>
	</tr>
	<tr>
		<td><font size="4"/>Password:</td>
		<td><input name = "pass" type = "password"/></td>
	</tr>
</table>

<p>
	<input class="button" type="submit" name="login" value="Login"/>
	<a href="./Registration.php"><button type="button">Register</button></a>
</p>
</form> 

<br>

<?php
if(isset($_POST['user'],$_POST['pass'])){
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$_SESSION['userID']= $user;

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql= "SELECT Cust_User, Password FROM Customer NATURAL JOIN User WHERE Customer.Cust_User=User.Username AND Customer.Cust_User=\"$user\" AND User.Password=\"$pass\"";
	$result = mysql_query($sql) or die(mysql_error());
	if (mysql_num_rows($result) == 1) {
		// header("Location:ChooseFuncCust.php");
		echo "<a href=\"./ChooseFuncCust.php\">";
		echo "<font color=\"green\">";
		echo "click here!";
		echo "</font>";
		echo "</a>";
	} else {
		$sql2= "SELECT Mgr_User, Password FROM Manager NATURAL JOIN User WHERE Manager.Mgr_User=User.Username AND Manager.Mgr_User=\"$user\" AND User.Password=\"$pass\"";
		$result2 = mysql_query($sql2) or die(mysql_error());
		if (mysql_num_rows($result2) == 1) {
			// header("Location:ChooseFuncMang.php");
			echo "<a href=\"./ChooseFuncMang.php\">";
			echo "<font color=\"green\">";
			echo "click here!";
			echo "</font>";
			echo "</a>";
		} else {
			echo "<font color=\"red\">";
			echo "Your username and/or password is wrong. </br> Are you sure you're a user?";
			echo "</font>";
		}
	}
}
?>

</center>
</body>
</html>
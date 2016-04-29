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


<a href="./loginPage.php"><img src="buzz.png" width="128" height="128"></a>

<form action="" method="POST"> 
<b><p class = "title"> REGISTRATION</p></b>

<table>
	<tr>
		<td><font size="4"/>Username:</td>
		<td><input name="user" maxlength="20"/></td>
	</tr>
	<tr>
		<td><font size="4"/>E-mail Address:</td>
		<td><input type="email" name="email"/></td>
	</tr>
	<tr>
		<td><font size="4"/>Password:</td>
		<td><input type = "password" name="pass" /></td>
	</tr>
	<tr>
		<td><font size="4"/>Confirm Password:</td>
		<td><input type = "password" name="passConfirm" /></td>
	</tr>
</table>

<br/>
<p>
	<input class="button" type="submit" name="submit" value="Create"/>
</p>
</form>

<br>

<?php

if(isset($_POST['user'],$_POST['pass'],$_POST['passConfirm'],$_POST['email'])){
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$passconfirm = $_POST['passConfirm'];
	$email = $_POST['email'];

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql = "SELECT Email FROM Customer WHERE Email = \"$email\"";
	$result = mysql_query($sql) or die(mysql_error());

	if (empty($pass) or empty($email) or empty($user)) {
		echo "<font color=\"red\">";
		echo "Some fields are not filled in";
		echo "</font>";
	} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo "<font color=\"red\">";
		echo "Invalid Email";
		echo "</font>";
	} else if($pass!=$passconfirm){
		echo "<font color=\"red\">";
		echo "Passwords don't match";
		echo "</font>";
	} else if(mysql_num_rows($result) > 0) {
		echo "<font color=\"red\">";
		echo "This e-mail has already been added";
		echo "</font>";
	} else {
		$sql = "SELECT * FROM User WHERE Username = \"$user\"";
		$result = mysql_query($sql) or die(mysql_error());
		if (mysql_num_rows($result) > 0) {
			echo "<font color=\"red\">";
			echo "Username is already taken";
			echo "</font>";	
		} else {
			$sql = "INSERT INTO User (Username, Password) VALUES (\"$user\", \"$pass\")";
			mysql_query($sql) or die(mysql_error());
			$sql2 = "INSERT INTO Customer (Cust_User, Email) VALUES (\"$user\", \"$email\")";
			mysql_query($sql2) or die(mysql_error());
			echo "<font color=\"green\">";
			echo "YAY! Click Buzz to go back to login!";
			echo "</font>";	
		}
	}
}

?>
</center>
</body>
</html>
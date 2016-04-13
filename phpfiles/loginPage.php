<?php
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

<br/><br/>
<form action=\"\" method=\"POST\" id = "mainBlock"> 
<b><p class = "title"> LOGIN PAGE</p></b>
<table>
	<tr>
		<td><font size="4"/>Username:</td>
		<td><input name = "username" type = "email"/></td>
	</tr>
	<tr>
		<td><font size="4"/>Password:</td>
		<td><input name = "password" type = "password"/></td>
	</tr>
</table>

<p>
	<!-- <a href="./ChooseFuncCust.html"><button type="button">Login</button></a>
	<a href="./Registration.html"><button type="button">Register</button></a>
 -->
	<td><a href="./ChooseFuncCust.html"><input type="button" name="loginCustomers" value="Login for Customers"/></a></td>
	<td><a href="./ChooseFuncMang.html"><input type="button" name="loginManagers" value="Login for Managers"/></a></td>
	<td><a href="./Registration.html"><input type="button" name="register" value="Register"/></a></td>
</p>
</form> 

<br>
<img src="buzz.png" width="128" height="128">

<?php
session_start();

if(isset($_POST['username'],$_POST['password'])){
$username = $_POST['username'];
$password = $_POST['password'];

$_SESSION['userID']= $user;

mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($database) or die(mysql_error());

// $sql= "SELECT Username, Password FROM Customer WHERE Username=\"$username\" AND Password=\"$password\"";
// $result = mysql_query($sql) or die(mysql_error());
// $sql2= "SELECT Username, Password FROM Management WHERE Username=\"$username\" AND Password=\"$password\"";
// $result2 = mysql_query($sql2) or die(mysql_error());

// $_SESSION['Customer']=$result;
// $_SESSION['Manager']=$result2;
// }

// if (mysql_num_rows($result) + mysql_num_rows($result2) == 1){
//     if(mysql_num_rows($result)==1){
//         header("Location:menuCustomer.php");}
//     elseif(mysql_num_rows($result2)==1){
//         header("Location:menuManagement.php");}
// }else{
//     $err = "Incorrect Login Information!";
//     }
//     echo "<font size=\"4\">";
//     echo "$err";
//     echo "<br/><br/><br/>";
//     echo "</font>";

?>


</center>
</body>
</html>


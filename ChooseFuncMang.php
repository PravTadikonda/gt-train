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
		<td align="center"><a href="./ViewRevenueReport.php"><font size="4"/>View Revenue Report </a></td>
	</tr>
	<tr>
		<td align="center"><a href="./ViewPopularRouteReport.php"><font size="4"/>View Popular Route Report </a></td>
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
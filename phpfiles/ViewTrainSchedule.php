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
<br/><br/>

<form action="\" method="POST" id = "mainBlock"> 
<b><p class = "title">VIEW TRAIN SCHEDULE</p></b>

<table>
	<tr>
		<td><font size="4"/>Train Number:</td>
		<td><input name="reservationID" maxlength="20"/></td>
	</tr>
</table>

<p>
	<a href="#"><button type="button">Search</button></a>
</p>
</form> 

<br>
<a href="./ChooseFuncCust.php"><img src="buzz.png" width="128" height="128"></a>

<?php

mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

?>
</center>
</body>
</html>
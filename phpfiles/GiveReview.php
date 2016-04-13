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
<form action=\"\" method=\"POST\" id = "mainBlock"> 
<b><p class = "title"> GIVE REVIEW</p></b>
<table>
	<tr>
		<td><font size="4"/>Train Number:</td>
		<td><input/></td>
	</tr>
	<tr>
		<td><font size="4"/>Rating:</td>
		<td><select>
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
		<td><textarea rows="4" cols="50"></textarea></td>
	</tr>

</table>

<p>
	<a href="./ChooseFunc.php"><button type="button">Submit</button></a>
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
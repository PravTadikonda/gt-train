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
<?php
include 'dbinfo.php';
?>

<html>
<title>GT Train</title>

<head>
  <link rel="stylesheet" href="style.css">
  <style>
  	#addCard {
  		border-right: solid black;
  		padding-right: 20px;
  	}
  	#deleteCard {
  		padding-left: 20px;
  	}
  </style>
</head>

<body >
<center> 
<h1>GEORGIA TECH TRAIN</h1>

<br/><br/>
<form action=\"\" method=\"POST\" id = "mainBlock"> 
<b><p class = "title"> PAYMENT INFORMATION</p></b>
<table>
	<tr>
		<td>
			<table id="addCard">
				<tr>
					<td><font size="4"/>Name on Card:</td>
					<td><input/></td>
				</tr>
				<tr>
					<td><font size="4"/>Card Number:</td>
					<td><input/></td>
				</tr>
				<tr>
					<td><font size="4"/>CVV:</td>
					<td><input/></td>
				</tr>
				<tr>
					<td><font size="4"/>Expiration Date:</td>
					<td>
						<select name="month">
				        	<option value="Nothing">--</option>
						    <option value="01">01</option>
						    <option value="02">02</option>
						    <option value="03">03</option>
						    <option value="04">04</option>
						    <option value="05">05</option>
						    <option value="06">06</option>
						    <option value="07">07</option>
						    <option value="08">08</option>
						    <option value="09">09</option>
						    <option value="10">10</option>
						    <option value="11">11</option>
						    <option value="12">12</option>
						</select>
						<!-- Try to make this dynamic -->
						<select name="year">
				        	<option value="Nothing">----</option>
				        	<option value="2016">2016</option>
				        	<option value="2017">2017</option>
				        	<option value="2018">2018</option>
				        	<option value="2019">2019</option>
				        	<option value="2020">2020</option>
				        	<option value="2021">2021</option>
				        	<option value="2022">2022</option>
				        	<option value="2023">2023</option>
						</select>
					</td>
				</tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr>
					<td colspan="2" align="center"><a href="./ChooseFunc.php"><button type="button">Save</button></a></td>
				</tr>
			</table>
		</td>
		<td>
			<table id="deleteCard">
				<tr>
					<td>Card Number:</td>
					<td><select>
			        	<option value="Nothing">--</option>
			        	<option value="example">xxxx-xxxx-xxxx</option>
					</select></td>
				</tr>
				<tr></tr>
				<tr></tr>
				<tr></tr>
				<tr>
					<td colspan="2" align="center"><a href="./ChooseFunc.php"><button type="button">Delete</button></a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
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
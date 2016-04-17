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
<br/><br/>

<form action="" method="POST"> 
<b><p class = "title"> SEARCH TRAIN</p></b>
<table>
  <tr>
    <td><font size="4"/>Departs From:</td>
    <td><select>
        <option value="Nothing">--</option>
        <option value="City1">City1</option>
        <option value="City2">City2</option>
        <option value="City3">City3</option>
        <option value="City4">City4</option>
        <option value="City5">City5</option>
    </select></td>
  </tr>
  <tr>
    <td><font size="4"/>Arrives At:</td>
    <td><select>
        <option value="Nothing">--</option>
        <option value="City1">City1</option>
        <option value="City2">City2</option>
        <option value="City3">City3</option>
        <option value="City4">City4</option>
        <option value="City5">City5</option>
    </select></td>
  </tr>
  <tr>
    <td><font size="4"/>Departure Date:</td>
    <td><input type="date" name="departDate"/></td>
  </tr>
</table>

<p>   </p> 
<br/>
<a href="#"><button type="button">Find Trains</button></a>
<input class="button" type="submit" name="submit" value="Submit"/>
</form> 

<br>
<a href="./ChooseFuncCust.php"><img src="buzz.png" width="128" height="128"></a>

<?php


// $bags = $_SESSION['bags'];
// $passangerName = $_SESSION['passangerName'];

echo "$bags</br>$passangerName";


mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

?>
</center>
</body>
</html>
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
<b><p class = "title">CONFIRMATION PAGE</p></b>

<?php
mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

$reservationID = $_SESSION['reserveID'];

echo "</br>";
echo "Reservation ID: <input value=\"$reservationID\" maxlength=\"20\"/>";
echo "</br></br>";
echo "Thank you for your purchase! Please save reservation ID for your records.";
echo "</br></br>";
echo "<a href=\"ChooseFuncCust.php\"><button style=\"width:250px\" type=\"button\">Go Back to Choose Functionality</button></a>";

?>

</center>
</body>
</html>
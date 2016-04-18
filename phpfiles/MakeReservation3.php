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
<b><p class = "title">MAKE RESERVATION</p></b>

<?php


date_default_timezone_set('America/New_York');
$user = $_SESSION['userID'];
$departName = $_SESSION['depart_name'];
$departLocation = $_SESSION['depart_location'];
$arriveName = $_SESSION['arrive_name'];
$arriveLocation = $_SESSION['arrive_location'];
$departDate = $_SESSION['depart_date'];
$bags = $_SESSION['bags'];
$passangerName = $_SESSION['passangerName'];
$price = $_SESSION['reserve_price'];
$class = $_SESSION['reserve_class'];
$trainNum = $_SESSION['train_num'];
mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

echo "<table border=\"1\" bordercolor=\"black\">";
    echo "<tr>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Duration</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Departs From</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Arrives At</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Class</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Price</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Number of Baggages</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Passanger Name</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Remove</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$trainNum</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/></td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$departLocation($departName)</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$arriveLocation($arriveName)</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$class</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$$price</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$bags</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/>$passangerName</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><input type=\"button\" value=\"Remove\"/></td>";
    echo "</tr>";
echo "</table>";

$sql = "SELECT Is_Student FROM Customer WHERE Cust_User=\"$user\"";
$result = mysql_query($sql) or die(mysql_error());
$student = mysql_fetch_array($result)[0];

$totalSum = $price;
if ($bags == 3) {
    $totalSum = $totalSum + 30;
} else if($bags == 4) {
    $totalSum = $totalSum + 60;
}
echo "</br>";
if ($student == 1) {
    echo "<font color=\"green\">";
    echo "Student Discount Applied";
    echo "</font>";
    $totalSum = $totalSum * .8;
}
echo "</br>";


echo "Total Cost of Reservation: <input value=\"$$totalSum\" maxlength=\"20\"/>";
echo "</br></br>";

$sql2 = "SELECT Card_Number FROM PaymentInfo WHERE Cust_User=\"$user\"";
$result2 = mysql_query($sql2) or die (mysql_error());
echo "<font size=\"4\"/>Use Card:";
echo "<select name=\"depart\">";
    echo "<option value=\"Nothing\">--</option>";
    while($row = mysql_fetch_array($result2)){
        $cardNum = substr($row[0], -4);
        echo "<option value=\"$row[0]\">$cardNum</option>";
    }
echo "</select>";
echo "    ";
echo "<a href=\"./PaymentInformation.php\">Add Card</a>";

echo "</br></br>";
echo "<a href=\"#\">Continue adding a train</a>";
echo "</br></br>";
echo "<a href=\"./TravelExtras.php\"><button type=\"button\">Back</button></a>";
echo "<input class=\"button\" type=\"submit\" name=\"submit\" value=\"Next\"/>";


        // echo "<script type=\"text/javascript\">";
        // echo "window.top.location=\"./Confirmation.php\"";
        // echo "</script>";

?>

</center>
</body>
</html>
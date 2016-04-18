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
<b><p class = "title">SELECT DEPARTURE</p></b>

<?php

date_default_timezone_set('America/New_York');
$user = $_SESSION['userID'];
$departName = $_SESSION['depart_name'];
$arriveName = $_SESSION['arrive_name'];
$departDate = $_SESSION['depart_date'];
mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

$sql = "CREATE OR REPLACE VIEW reservStation AS (SELECT Name, Stop.Train_Number, Arrival_Time, Departure_Time, First_Class_Price,
        Second_Class_Price FROM Stop JOIN Train_Route WHERE Stop.Train_Number = Train_Route.Train_Number)";
mysql_query($sql) or die(mysql_error());

//check to make sure no negative times
$sql2 = "SELECT Arrival_Station.Train_Number, Departure_Station.Departure_Time, Arrival_Station.Arrival_Time, 
        Arrival_Station.First_Class_Price, Arrival_Station.Second_Class_Price 
        FROM reservStation Arrival_Station JOIN reservStation Departure_Station 
        WHERE Arrival_Station.Train_Number = Departure_Station.Train_Number AND Arrival_Station.Name != Departure_Station.Name 
        AND Departure_Station.Name = \"$departName\" AND Arrival_Station.Name = \"$arriveName\";";
$result2 = mysql_query($sql2) or die(mysql_error());

if(mysql_num_rows($result2) == 0) {
    echo "<font color=\"red\">";
    echo "You cannot make those reservations with those stops.$departName";
    echo "</font>";
    echo "</br></br>";
    echo "<a href=\"./MakeReservation1.php\"><button type=\"button\">Back</button></a>";
} else {
    echo "<form action=\"\" method=\"POST\">";
    echo "<table border=\"1\" bordercolor=\"black\">";
    echo "<tr>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Train Number</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>Duration</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>1st Class Price</td>";
        echo "<td bgcolor=\"#e6f3ff\"><center/><font size=\"4\"/><b/>2nd Class Price</td>";
    echo "</tr>";

    while($row = mysql_fetch_array($result2)) {
        $sql3 = "SELECT hour(timediff(\"$row[1]\", \"$row[2]\")), minute(timediff(\"$row[1]\", \"$row[2]\"))";
        $result3 = mysql_query($sql3) or die(mysql_error());
        $difference = mysql_fetch_array($result3);
        $hourDiff = $difference[0];
        $minDiff = $difference[1];

        $arrivalTimeFormat = DATE("g:i A", strtotime("$row[2]"));
        $departTimeFormat = DATE("g:i A", strtotime("$row[1]"));
        echo "<tr>";
            echo "<td bgcolor=\"#e6f3ff\"><center/>$row[0]</td>";
            echo "<td bgcolor=\"#e6f3ff\">$departTimeFormat - $arrivalTimeFormat
                    </br>$hourDiff hrs $minDiff mins</td>";
            echo "<td bgcolor=\"#e6f3ff\"><center/><input type=\"radio\" name=\"price\" value=\"$row[3]_1_$row[0]\"/>$row[3]</td>";
            echo "<td bgcolor=\"#e6f3ff\"><center/><input type=\"radio\" name=\"price\" value=\"$row[4]_2_$row[0]\"/>$row[4]</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</br>";
    echo "<a href=\"./MakeReservation1.php\"><button type=\"button\">Back</button></a>";
    echo "<input class=\"button\" type=\"submit\" name=\"submit\" value=\"Next\"/>";
    echo "</form>";
}

if(isset($_POST["price"])) {
    $classPrice = $_POST["price"];
    $pattern = '/[_]/';
    $price = preg_split($pattern, $classPrice)[0];
    $class = preg_split($pattern, $classPrice)[1];
    $trainNum = preg_split($pattern, $classPrice)[2];
    $_SESSION['reserve_price'] = $price;
    $_SESSION['reserve_class'] = $class;
    $_SESSION['train_num'] = $trainNum;

    if(empty($classPrice)) {
        echo "<font color=\"red\">";
        echo "Select a price";
        echo "</font>";
    } else {
        echo "<script type=\"text/javascript\">";
        echo "window.top.location=\"./TravelExtras.php\"";
        echo "</script>";
    }
}
?>

</center>
</body>
</html>
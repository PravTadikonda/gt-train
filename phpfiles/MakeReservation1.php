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

<?php

$user = $_SESSION['userID'];
mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

$sql = "SELECT * FROM Station";
$result = mysql_query($sql) or die(mysql_error());
$result2 = mysql_query($sql) or die(mysql_error());

echo "<form action=\"\" method=\"POST\">";
echo "<b><p class = \"title\"> SEARCH TRAIN</p></b>";
echo "<table>";
    echo "<tr>";
        echo "<td><font size=\"4\"/>Departs From:</td>";
        echo "<td><select name=\"depart\">";
            echo "<option value=\"Nothing\">--</option>";
            while($row = mysql_fetch_array($result)){
                echo "<option value=\"$row[0]_$row[1]\">$row[1]($row[0])</option>";
            }
        echo "</select></td>";
    echo "</tr>";
        echo "<td><font size=\"4\"/>Arrives At:</td>";
        echo "<td><select name=\"arrive\">";
            echo "<option value=\"Nothing\">--</option>";
            while($row = mysql_fetch_array($result2)){
                echo "<option value=\"$row[0]_$row[1]\">$row[1]($row[0])</option>";
            }
        echo "</select></td>";
    echo "<tr>";
        echo "<td><font size=\"4\"/>Departure Date:</td>";
        echo "<td><input type=\"date\" name=\"departDate\"/></td>";
    echo "</tr>";
echo "</table>";
echo "<br/>";
echo "<a href=\"./ChooseFuncCust.php\"><button type=\"button\">Back</button></a>";
echo "<input class=\"button\" type=\"submit\" name=\"submit\" value=\"Find Trains\"/>";
echo "</form>";

if(isset($_POST["depart"], $_POST["arrive"])) {
    $departDate = $_POST["departDate"];
    $dep = $_POST["depart"];
    $arr = $_POST["arrive"];
    $pattern = '/[_]/';
    $departLocation = preg_split($pattern, $dep)[1];
    $departName = preg_split($pattern, $dep)[0];
    $arriveLocation = preg_split($pattern, $arr)[1];
    $arriveName = preg_split($pattern, $arr)[0];

    $_SESSION['depart_name'] = $departName;
    $_SESSION['depart_location'] = $departLocation;
    $_SESSION['arrive_name'] = $arriveName;
    $_SESSION['arrive_location'] = $arriveLocation;
    $_SESSION['depart_date'] = $departDate;

    $sql3 = "SELECT CURDATE()";
    $result3 = mysql_query($sql3) or die(mysql_error());
    $today = mysql_fetch_array($result3)[0];

    if($departLocation == 'Nothing' or $arriveLocation == 'Nothing' or empty($departDate)) {
        echo "<font color=\"red\">";
        echo "Some fields are not filled in";
        echo "</font>";
    } else if($departLocation == $arriveLocation) {
        echo "<font color=\"red\">";
        echo "You cannot have the same depart and arrive locations";
        echo "</font>";
    } else if($today > $departDate) {
        echo "<font color=\"red\">";
        echo "This date already passed, sorry.";
        echo "</font>";
    } else {
        echo "<script type=\"text/javascript\">";
        echo "window.top.location=\"./MakeReservation2.php\"";
        echo "</script>";
    }
}
?>

</center>
</body>
</html>
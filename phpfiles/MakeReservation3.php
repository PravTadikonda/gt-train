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
$departTime = $_SESSION['depart_time'];
$arriveTime = $_SESSION['arrive_time'];

$newReserve = array($user,$departName,$departLocation,$arriveName,$arriveLocation,$departDate,$bags,$passangerName,$price,$class,$trainNum,$departTime,$arriveTime);
$allReservations = $_SESSION['all_reservations'];

$_SESSION['bags'] = NULL;

$alreadyAdded = False;
foreach ($allReservations as $res) {
    if ($trainNum == $res[10]) {
        echo "<font color=\"red\">";
        echo "You cannot choose same train number as you have already chosen</br></br>";
        echo "</font>";
        $alreadyAdded = True;
        break;
    }
}

if (!$alreadyAdded and (!empty($bags) or $bags == "0")) {
    $allReservations[] = $newReserve;
}

$_SESSION['all_reservations'] = $allReservations;
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
    foreach ($allReservations as $reserve) {
        if ($reserve[11] > $reserve[12]) {
            $sql3 = "SELECT hour(timediff(\"-24:00:00\", timediff(\"$reserve[12]\", \"$reserve[11]\"))), minute(timediff(\"-24:00:00\", timediff(\"$reserve[12]\", \"$reserve[11]\")))";
        } else {
            $sql3 = "SELECT hour(timediff(\"$reserve[11]\", \"$reserve[12]\")), minute(timediff(\"$reserve[11]\", \"$reserve[12]\"))";
        }
        $result3 = mysql_query($sql3) or die(mysql_error());
        $difference = mysql_fetch_array($result3);
        $hourDiff = $difference[0];
        $minDiff = $difference[1];

        $monthDay = date("F jS", strtotime($reserve[5]));
        $arrivalTimeFormat = DATE("g:iA", strtotime($reserve[12]));
        $departTimeFormat = DATE("g:iA", strtotime($reserve[11]));

        $string = str_replace(' ', '', $reserve[10]);
        echo "<tr>";
                echo "<td bgcolor=\"#e6f3ff\"><center/>$reserve[10]</td>";
                echo "<td bgcolor=\"#e6f3ff\"> $monthDay $departTimeFormat - $arrivalTimeFormat </br> $hourDiff hrs $minDiff mins</td>";
                echo "<td bgcolor=\"#e6f3ff\"><center/>$reserve[2]($reserve[1])</td>";
                echo "<td bgcolor=\"#e6f3ff\"><center/>$reserve[4]($reserve[3])</td>";
                echo "<td bgcolor=\"#e6f3ff\"><center/>$reserve[9]</td>";
                echo "<td bgcolor=\"#e6f3ff\"><center/>$$reserve[8]</td>";
                echo "<td bgcolor=\"#e6f3ff\"><center/>$reserve[6]</td>";
                echo "<td bgcolor=\"#e6f3ff\"><center/>$reserve[7]</td>";
                echo "<form action=\"Remove.php\" method=\"POST\">";
                echo "<td bgcolor=\"#e6f3ff\"><center/><input type=\"submit\" name=\"$string\" value=\"Remove\"/></td>";
                echo "</form>";
        echo "</tr>";
    }
echo "</table>";

echo "<form action=\"\" method=\"POST\">";
$sql = "SELECT Is_Student FROM Customer WHERE Cust_User=\"$user\"";
$result = mysql_query($sql) or die(mysql_error());
$student = mysql_fetch_array($result)[0];

$allTotalSum = 0;
foreach ($allReservations as $reser) {
    $totalSum = $reser[8];
    if ($reser[6] == 3) {
        $totalSum = $totalSum + 30;
    } else if($reser[6] == 4) {
        $totalSum = $totalSum + 60;
    }
    $allTotalSum = $allTotalSum + $totalSum;
}
    
echo "</br>";
if ($student == 1) {
    echo "<font color=\"green\">";
    echo "Student Discount Applied";
    echo "</font>";
    $allTotalSum = $allTotalSum * .8;
}

$allTotalSum = number_format($allTotalSum, 2, '.', ',');
echo "</br>";

echo "Total Cost of Reservation: <input value=\"$$allTotalSum\" maxlength=\"20\"/>";
echo "</br></br>";

$sql2 = "SELECT Card_Number FROM PaymentInfo WHERE Cust_User=\"$user\" AND Card_Number NOT LIKE \"placeholder%\"";
$result2 = mysql_query($sql2) or die (mysql_error());
echo "<font size=\"4\"/>Use Card:";
echo "<select name=\"reserveCard\">";
    echo "<option value=\"Nothing\">--</option>";
    while($row = mysql_fetch_array($result2)){
        $cardNum = substr($row[0], -4);
        echo "<option value=\"$row[0]\">$cardNum</option>";
    }
echo "</select>";
echo "    ";
echo "<a href=\"./PaymentInformation.php\">Add Card</a>";

echo "</br></br>";
echo "<a href=\"./MakeReservation1.php\">Continue adding a train</a>";
echo "</br></br>";
echo "<input class=\"button\" type=\"submit\" name=\"confirm\" value=\"Submit\"/>";
echo "</form>";


if(isset($_POST["confirm"])) {
    $allReservations = $_SESSION['all_reservations'];
    $user = $_SESSION['userID'];
    $cardNum = $_POST['reserveCard'];

    if ($cardNum == 'Nothing') {
        echo "</br></br>";
        echo "<font color=\"red\">";
        echo "Select a card";
        echo "</font>";
    } else if(empty($allReservations)) {
        echo "</br></br>";
        echo "<font color=\"red\">";
        echo "You removed all reservations.</br>Either add another train, or click on Buzz to go back to menu.";
        echo "</font>";
    } else {
        $reservationID = rand(10000, 99999);
        $idList = array();
        $sql4 = "SELECT Reservation_ID FROM Reservation";
        $result4 = mysql_query($sql4) or die();
        while ($row = mysql_fetch_array($result4)) {
            $idList[] = $row[0];
        }
        while (in_array($reservationID, $idList)) {
            $reservationID = rand(10000, 99999);
        }
        $_SESSION['reserveID'] = $reservationID;

        $sql2 = "INSERT INTO Reservation (Reservation_ID, Is_Cancelled, Card_Number, Cust_User) 
                VALUES (\"$reservationID\",\"0\",\"$cardNum\",\"$user\")";
        mysql_query($sql2) or die(mysql_error());

        foreach ($allReservations as $addReserve) {
            $totalSum = $addReserve[8];
            if ($addReserve[6] == 3) {
                $totalSum = $totalSum + 30;
            } else if($addReserve[6] == 4) {
                $totalSum = $totalSum + 60;
            }
            $sql3 = "INSERT INTO Reserves (Train_Number, Reservation_ID, Class, Departure_Date, Passanger_Name, Number_Baggages, 
                Departs_From, Arrives_At, Total_Cost) VALUES (\"$addReserve[10]\",\"$reservationID\",\"$addReserve[9]\",
                \"$addReserve[5]\",\"$addReserve[7]\",\"$addReserve[6]\",\"$addReserve[2]\",\"$addReserve[4]\",\"$totalSum\")";
            mysql_query($sql3) or die(mysql_error());
        }

        $_SESSION['all_reservations'] = array();

        echo "<script type=\"text/javascript\">";
        echo "window.top.location=\"./Confirmation.php\"";
        echo "</script>";
    }
}

?>

</center>
</body>
</html>
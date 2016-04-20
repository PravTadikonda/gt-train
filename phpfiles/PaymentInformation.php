<?php
session_start();
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

<a href="./ChooseFuncCust.php"><img src="buzz.png" width="128" height="128"></a>
<b><p class = "title"> PAYMENT INFORMATION</p></b>

<?php

$user = $_SESSION['userID'];

mysql_connect($host,$username,$password) or die("Unable to connect");
mysql_select_db($database) or die("Unable to select database");

echo "<table>";
	echo "<tr>";
		echo "<td>";
			echo "<form action=\"\" method=\"POST\">";
			echo "<table id=\"addCard\">";
				echo "<tr>";
					echo "<td><font size=\"4\"/>Name on Card:</td>";
					echo "<td><input name=\"cardName\"/></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><font size=\"4\"/>Card Number:</td>";
					echo "<td><input pattern=\".{16,}\" required title=\"16 characters minimum\" type=\"text\" name=\"cardNumber\" maxlength=\"16\"/></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><font size=\"4\"/>CVV:</td>";
					echo "<td><input pattern=\".{3,}\" required title=\"3 characters minimum\" type=\"text\" name=\"cardCVV\" maxlength=\"3\"/></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><font size=\"4\"/>Expiration Date:</td>";
					echo "<td>";
						echo "<select name=\"month\">";
							echo "<option value=\"Nothing\">--</option>";
						    echo "<option value=\"01\">01</option>";
						    echo "<option value=\"02\">02</option>";
						    echo "<option value=\"03\">03</option>";
						    echo "<option value=\"04\">04</option>";
						    echo "<option value=\"05\">05</option>";
						    echo "<option value=\"06\">06</option>";
						    echo "<option value=\"07\">07</option>";
						    echo "<option value=\"08\">08</option>";
						    echo "<option value=\"09\">09</option>";
						    echo "<option value=\"10\">10</option>";
						    echo "<option value=\"11\">11</option>";
						    echo "<option value=\"12\">12</option>";
						echo "</select>";
						echo "&nbsp";
						echo "<select name=\"year\">";
							echo "<option value=\"Nothing\">----</option>";
				        	echo "<option value=\"2016\">2016</option>";
				        	echo "<option value=\"2017\">2017</option>";
				        	echo "<option value=\"2018\">2018</option>";
				        	echo "<option value=\"2019\">2019</option>";
				        	echo "<option value=\"2020\">2020</option>";
				        	echo "<option value=\"2021\">2021</option>";
				        	echo "<option value=\"2022\">2022</option>";
				        	echo "<option value=\"2023\">2023</option>";
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				echo "<tr></tr>";
				echo "<tr></tr>";
				echo "<tr></tr>";
				echo "<tr>";
					echo "<td colspan=\"2\" align=\"center\"><input class=\"button\" name=\"addCard\" type=\"submit\" value=\"Save\"/></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</td>";
		echo "<td>";
			echo "<form action=\"\" method=\"POST\">";
			echo "<table id=\"deleteCard\">";
				echo "<tr>";
					$sql = "SELECT Card_Number FROM PaymentInfo WHERE Cust_User=\"$user\" AND Card_Number NOT LIKE \"placeholder%\"";
					$result = mysql_query($sql) or die (mysql_error());
					echo "<td>Card Number:</td>";
					echo "<td><select name=\"card_num\">";
					echo "<option value=\"Nothing\">----</option>";
					while($row = mysql_fetch_array($result)){
				        $cardNum = substr($row[0], -4);
				        echo "<option value=\"$row[0]\">$cardNum</option>";
				    }
					echo "</select></td>";
				echo "</tr>";
				echo "<tr></tr>";
				echo "<tr>";
					echo "<td colspan=\"2\" align=\"center\"><input class=\"button\" type=\"submit\" name=\"deleteCard\" value=\"Delete\"/></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
		echo "</td>";
	echo "</tr>";
echo "</table>";

if(isset($_POST["addCard"])) {
	$user = $_SESSION['userID'];
	$cardName = $_POST['cardName'];
	$cardNumber = $_POST['cardNumber'];
	$cardCVV = $_POST['cardCVV'];
	$cardMonth = $_POST['month'];
	$cardYear = $_POST['year'];

	date_default_timezone_set('America/New_York');
	$expDate = Date("$cardYear-$cardMonth-01");

	mysql_connect($host,$username,$password) or die("Unable to connect");
	mysql_select_db($database) or die("Unable to select database");

	$sql5 = "SELECT CURDATE()";
    $result5 = mysql_query($sql5) or die(mysql_error());
    $today = mysql_fetch_array($result5)[0];

	$sql2 = "SELECT Card_Number FROM PaymentInfo WHERE Card_Number=\"$cardNumber\"";
	$result2 = mysql_query($sql2) or die(mysql_error());
	
	if(empty($cardNumber) or empty($cardName) or empty($cardCVV)) {
		echo "<font color=\"red\">";
		echo "Some fields are left empty.";
		echo "</font>";
	} else if($cardMonth == "Nothing" or $cardYear == "Nothing") {
		echo "<font color=\"red\">";
		echo "You have to select a Year and a Date";
		echo "</font>";
	} else if(mysql_num_rows($result2) > 0) {
		echo "<font color=\"red\">";
		echo "This card number is already in our system";
		echo "</font>";
	} else if(!is_numeric($cardNumber) or !is_numeric($cardCVV)) {
		echo "<font color=\"red\">";
		echo "Card number and CVV have to be number inputs";
		echo "</font>";
	} else if($expDate <= $today) {
		echo "<font color=\"red\">";
		echo "This card has already expired";
		echo "</font>";
	} else {
		$sql3 = "INSERT INTO PaymentInfo (Cust_User, Card_Number, CVV, Exp_Date, Name_on_Card) 
				VALUES (\"$user\",\"$cardNumber\",\"$cardCVV\",\"$expDate\",\"$cardName\")";
		$result3 = mysql_query($sql3) or die(mysql_error());
		echo "<script type=\"text/javascript\">";
	    echo "window.top.location=\"./MakeReservation3.php\"";
	    echo "</script>";
	}
}

if(isset($_POST["deleteCard"])) {
	$user = $_SESSION['userID'];
	$cardNum = $_POST['card_num'];

	if($cardNum == "Nothing") {
		echo "<font color=\"red\">";
		echo "Put in a card number";
		echo "</font>";
	} else {
		mysql_connect($host,$username,$password) or die("Unable to connect");
		mysql_select_db($database) or die("Unable to select database");

		//get biggest placeholder value
		$sql = "";
		$result = mysql_query($sql) or die(mysql_error());
		$placeholder = ""; // *testing*

		if($placeholder == "") {
			$placeholder = "placeholder000000";
		} else {
			$holderVal = intval(str_replace("placeholder", "", "$placeholder"));
			$holderVal++;
			$holderVal = sprintf("%05d", $holderVal);
			$placeholder = "placeholder" . $holderVal;
		}	
		
		//get departure dates that > today for given cardnum & user
		$sql2 = "";
		$result2 = mysql_query($sql2) or die(mysql_error());
		if (mysql_num_rows($result2) > 0) {
			echo "<font color=\"red\">";
			echo "You have future reservations for this card";
			echo "</font>";
		} else {
			//update what you need to 
			$sql3 = "";
			mysql_query($sql3) or die(mysql_error());

			echo "<script type=\"text/javascript\">";
		    echo "window.top.location=\"./MakeReservation3.php\"";
		    echo "</script>";
		}
	}
}
?>
</center>
</body>
</html>
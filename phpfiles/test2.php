<?php
include 'test.php';
?>

<html>
<body>

	HEY
<?php

mysql_connect($host,$username,$password) or die("OPPS");
mysql_select_db($database) or die(mysql_error());
?>

</body>

</html>
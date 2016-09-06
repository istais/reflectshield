<?php
die('remove this to test');
use ReflectShield\ReflectShield;
require_once __DIR__.'/../../vendor/autoload.php';
if(!isset($AVOIDPREPROCESS)){ 
	$AVOIDPREPROCESS = true;
	$shield = new ReflectShield;
	include __FILE__;
	return;
}
?>
<html>
<body>
<?php
$link = mysql_connect('localhost', 'root', 'root') or die('Could not connect: ' . mysql_error());
mysql_select_db('mysql') or die('Could not select database');
$query = 'SELECT host FROM user where User =\'' . $_GET['c'] . '\'';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
echo "<table>\n";
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";
mysql_free_result($result);
mysql_close($link);
?>
</body>
</html>
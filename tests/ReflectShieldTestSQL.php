<?php 
use ReflectShield\ReflectShield;
$_GET['c']="root";
ob_start();
if(!isset($AVOIDPREPROCESS)){ 
	$AVOIDPREPROCESS = true;	
	$shield = new ReflectShield;
	include __FILE__;
	return;
}


class ReflectShieldTestSQL extends PHPUnit_Framework_TestCase {
 
  public function testReflectShield()
  { 

    ob_start();
    $link = mysqli_connect('localhost', 'root', 'root','mysql') or die('Could not connect: ' . mysql_error());
	$query = 'SELECT host FROM user where User =\'' . $_GET['c'] . '\'';
	$result = mysqli_query($link,$query) or die('Query failed: ' . mysql_error());
	$count = 0;
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
	    $count = $count + 1;
	}
	echo $count;
    $output = ob_get_contents();
    $this->assertEquals($count,1);

  }
 
}
?>

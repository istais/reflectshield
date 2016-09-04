<?php 
use ReflectShield\ReflectShield;

class ReflectShieldTest extends PHPUnit_Framework_TestCase {
 
  public function testReflectShield()
  { 
  	/* Emulate start of PHP script with GET parameter */
  	ob_start();
  	$_GET['f']='<script>alert(1);</script>';

  	/* Actual Script */
    $shield = new ReflectShield;
    echo $_GET['f'];

    /* Emulate end of PHP script */
    $shield->__destruct();
    $output = ob_get_contents();
    $this->assertEquals('&lt;script&gt;alert(1);&lt;/script&gt;',$output);
  }
 
}
?>

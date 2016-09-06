<?php 
use ReflectShield\ReflectShield;
$_GET['f']='<script>alert(1);</script>';
$shield = new ReflectShield;

class ReflectShieldTestXSS extends PHPUnit_Framework_TestCase {
 
  public function testReflectShield()
  { 

    ob_start();
    print $_GET['f'];
    $output = ob_get_contents();

    $this->assertEquals(html_entity_decode(htmlentities($_GET['f'],ENT_QUOTES),ENT_COMPAT,'ISO-8859-1'),$output);
  }
 
}
?>

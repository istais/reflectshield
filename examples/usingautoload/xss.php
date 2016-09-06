<?php
die('remove this to test');
use ReflectShield\ReflectShield;
require_once __DIR__.'/../../vendor/autoload.php';
$shield = new ReflectShield;
?>
<html>
<body>
<p>It's like comparing <?php echo $_GET[f];?> to <?php echo $_GET[m];?>.</p>
</body>
</html>
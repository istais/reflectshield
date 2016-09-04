<?php die('Remove this to test') ?>
<?php
use ReflectShield\ReflectShield;
require_once __DIR__.'/../../vendor/autoload.php';
$shield = new ReflectShield;
?>
<html>
<body>
<p>It's like comparing <?php echo $_GET[f];?> to oranges.</p>
</body>
</html>
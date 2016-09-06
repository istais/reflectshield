<?php
	use ReflectShield\ReflectShield;
	require_once __DIR__.'/../../vendor/autoload.php'; /* Path to your vendor folder */
	if(!isset($AVOIDPREPROCESS)){ 
		$AVOIDPREPROCESS = true;
		$shield = new ReflectShield;
		include __FILE__;
		return;
	}
?>
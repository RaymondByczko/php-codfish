<?php
	$a = "new string";
	$b = &$a;
	$c = &$a;
	xdebug_debug_zval('a');
?>

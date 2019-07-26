<?php
	$a = "new string";
	$b = $a;
	xdebug_debug_zval('a');
	echo 'a='.$a."\n";
	echo 'b='.$b."\n";
	echo 'change b and inspect a'."\n";
	$b = "old string";
	echo 'a='.$a."\n";
	echo 'b='.$b."\n";
?>

<?php
	$a = "new string";
	$b = $a;
	echo 'a='.$a."\n";
	echo 'b='.$b."\n";
	echo 'change a and inspect b'."\n";
	$a = "old string";
	echo 'a='.$a."\n";
	echo 'b='.$b."\n";
?>

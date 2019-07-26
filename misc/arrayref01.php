<?php
	$a = array();
	$a[] = 5;
	$a[] = 6;
	$a[] = 7;

	$b = $a;

	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";

	$b[0] = 11;

	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";


?>

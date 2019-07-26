<?php
/*
 * @file arrayref02.php
 * @location php-codfish/misc/
 * @author RByczko
 * @company self
 * @start_date 2019-07-24
 * @purpose Create a simple array of primitive types, that is, of ints.
 * Assign a reference of it to another variable.
 *
 * Print out the original array and then the reference.
 *
 * Change a variable in the reference.
 *
 * Print out the original array and then the reference.
 *
 * Observe.
 *
 * @conclusion Changing an element in the reference changes
 * it and the other array element.
 */
?>
<?php
	$a = array();
	$a[] = 5;
	$a[] = 6;
	$a[] = 7;

	$b = &$a;

	echo '*** BEFORE CHANGING ARRAY ELEMENT VIA REFERENCE'."\n";
	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";

	$b[0] = 11;

	echo '*** AFTER CHANGING ARRAY ELEMENT VIA REFERENCE'."\n";
	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";


?>

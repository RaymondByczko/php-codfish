<?php
/** @file arrayobjectcopy02.php
  * @location php-codfish/misc/
  * @purpose Experiment with array assignment where array
  * elements are objects.  Its predicted that with deep_copy
  * the assignment is deep. That is, a is assigned an object.
  * Then a is assigned to b.  b is changed.  The change will
  * be not be observed in a.
  */
?>
<?php
	function deep_copy(&$variable) { return unserialize(serialize($variable)); }

	class MyClass {
		public $x;
		public $y;
		public function __construct($x,$y)
		{
			$this->x = $x;
			$this->y = $y;
		}
	}

	$a = array();
	$a[] = new MyClass(2,3);
	$a[] = new MyClass(6,7);
	$a[] = new MyClass(10,11);

	echo '**** **** ****'."\n";
	echo '*** ASSIGN USING SHALLOW COPY'."\n";
	echo '**** **** ****'."\n";


	// This should do a unique copy.
	// It will be deep.
	// Thus changing b will not result in change to a.
	// Lets see.
	// (It turns out its ... .
	// Changing b results in ... to a.)
	$b = deep_copy($a);

	echo '*** PRINT OUT A BEFORE CHANGE'."\n";
	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	echo '*** PRINT OUT B BEFORE CHANGE'."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";
	echo '***************************'."\n";
	echo '*** *** MAKE CHANGE TO b[0] *** ***'."\n";
	$b[0]->x = 55;
	$b[0]->y = 65;


	echo '*** PRINT OUT A AFTER CHANGE'."\n";
	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	echo '*** PRINT OUT B AFTER CHANGE'."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";


?>

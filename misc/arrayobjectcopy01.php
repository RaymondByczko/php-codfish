<?php
/** @file arrayobjectcopy01.php
  * @location php-codfish/misc/
  * @purpose Experiment with array assignment where array
  * elements are objects.  Its predicted that without clone
  * the assignment is shallow. That is, a is assigned objects.
  * Then a is assigned to b.  b is changed.  The change will
  * be observed in a.
  */
?>
<?php
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


	// This should not do a unique copy.
	// It will be shallow, not deep.
	// Thus changing b will result in change to a.
	// Lets see.
	// (It turns out its shallow as predicted.
	// Changing b results in change to a.)
	$b = $a;

	echo '*** PRINT OUT A BEFORE CHANGE'."\n";
	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	echo '*** PRINT OUT B BEFORE CHANGE'."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";
	echo '***************************'."\n";
	echo '*** *** MAKE CHANGE *** ***'."\n";
	$b[0]->x = 55;
	$b[0]->y = 65;


	echo '*** PRINT OUT A AFTER CHANGE'."\n";
	$a_ve = var_export($a, TRUE);
	echo $a_ve."\n";
	echo '*** PRINT OUT B AFTER CHANGE'."\n";
	$b_ve = var_export($b, TRUE);
	echo $b_ve."\n";


?>

<?php
/**
  * @file TitleDataCollectionTest.php
  * @location php-codfish/tests
  * @company self
  * @author Raymond Byczko
  * @start_date
  * @history 2019-07-04; RByczko; Added testSortx10. Corrected data line
  * in $linesx10. Added testLinkx10.
  * @history 2019-07-04; RByczko; Added test data $linesx5 and
  * $expectedPieceFirstx5.  Added a test method testLinkx5.
  * @history 2019-07-17; RByczko; Basic implementation of
  * testLinkx20autogenerate.
  *	@history 2019-07-17; RByczko; Added testLinkx2000autogenerate.
  */
use PHPUnit\Framework\TestCase;
use RaymondByczko\PhpCodfish\TitleData;
use RaymondByczko\PhpCodfish\TitleDataCollection;
use RaymondByczko\PhpCodfish\TitleDataFileCreateAttributes;
use RaymondByczko\PhpCodfish\TitleUtilities;

class TitleDataCollectionTest extends TestCase
{
	protected $linesx10 = array(
		't01	short	Apples of Zen	Apples of Zen	0	1994	\N	1	Documentary',
		't02	short	Zen in Net	Zen in Net	0	1892	\N	5	Animation',
		't03	short	Zen of Met	Zen of Met	0	1892	\N	4	Animation',
		't04	short	Apples of Xerox	Apples of Xerox	0	1992	\N	\N	Animation',
		't05	short	Base of Apples	Base of Apples	0	1993	\N	1	Comedy',
		't06	short	Point of View	Point of View	0	1994	\N	1	Short',
		't07	short	Dance of Apples	Dance of Apples	0	1994	\N	1	Sport',
		't08	short	Cats of Wales	Cats of Wales	0	1994	\N	1	Documentary',
		't09	movie	View of Apples	View of Apples	0	1995	\N	45	Romance',
		't10	short	View of Zen	View of Zen	0	1995	\N	1	Documentary'
	);

	/**
	  * Small array in reverse order.  Easy to order. Longest title is easy to determine.
	  */
	protected $linesx5 = array(
		't01	short	Envy of Fish	Envy of Fish	0	1993	\N	1	Comedy',
		't02	short	Deer of Envy	Deer of Envy	0	1992	\N	\N	Animation',
		't03	short	Care of Deer	Care of Deer	0	1892	\N	4	Animation',
		't04	short	Books in Care	Books in Care	0	1892	\N	5	Animation',
		't05	short	Apples of Books	Apples of Books	0	1994	\N	1	Documentary'
	);

	/**
	  * These are the expected pieceFirst values when the array of $linesx5 is sorted
	  * and linked.
	  */
	protected $expectedPieceFirstx5 = array(
		'Apples',
		'Books',
		'Care',
		'Deer',		
		'Envy',
		'Fish'
	);

	protected $linesx7 = array(
		't01	short	A of Z	A of Z	0	1994	\N	1	Documentary',
		't02	short	Z in N	Z in N	0	1892	\N	5	Animation',
		't03	short	Q of M	Q of M	0	1892	\N	4	Animation',
		't04	short	E of X	E of X	0	1992	\N	\N	Animation',
		't05	short	B of F	B of F	0	1993	\N	1	Comedy',
		't06	short	P of V	P of V	0	1994	\N	1	Short',
		't07	short	D of A	D of A	0	1994	\N	1	Sport',
		't08	short	C of W	C of W	0	1994	\N	1	Documentary'
	);


	

	public function testSorted()
	{
		$objTDC = new TitleDataCollection();

		$aLine = 'tt0000001	short	Apples of Zen	Apples of Zen	0	1994	\N	1	Documentary';
		$lineNumber = 1;
		$objTD1 = new TitleData();
		$objTD1->getPieces($aLine, $lineNumber);
		$objTDC->add($objTD1);

		$aLine = 'tt0000008	short	Cats of Wales	Cats of Wales	0	1994	\N	1	Documentary,Short';
		$lineNumber = 2;
		$objTD2 = new TitleData();
		$objTD2->getPieces($aLine, $lineNumber);
		$objTDC->add($objTD2);


		$aLine = 'tt0000005	short	Base of Apples	Base of Apples	0	1993	\N	1	Comedy,Short';
		$lineNumber = 3;
		$objTD3 = new TitleData();
		$objTD3->getPieces($aLine, $lineNumber);
		$objTDC->add($objTD3);

		$sorted = $objTDC->getSorted();
		$this->assertFalse($sorted);
		$objTDC->sort();
		$sorted = $objTDC->getSorted();
		$this->assertTrue($sorted);

		$collection = $objTDC->getTDC();
		$sizeCollection = count($collection);
		$this->assertEquals(3, $sizeCollection);

		$aTitleData = $collection[0];
		$this->assertEquals('Apples', $aTitleData->pieceFirst);

		$aTitleData = $collection[1];
		$this->assertEquals('Base', $aTitleData->pieceFirst);

		$aTitleData = $collection[2];
		$this->assertEquals('Cats', $aTitleData->pieceFirst);


	}

	public function testSortedx10()
	{
		$objTDC = new TitleDataCollection();

		$sizeLinesx10 = count($this->linesx10);

		for ($i=0; $i < $sizeLinesx10; $i++)
		{
			$objTD = new TitleData();
			$aLine = $this->linesx10[$i];
			$objTD->getPieces($aLine, $i);
			$objTDC->add($objTD);
		}

		$objTDC->sort();
		$sorted = $objTDC->getSorted();
		$this->assertTrue($sorted);

		$collection = $objTDC->getTDC();
		$sizeCollection = count($collection);
		$this->assertEquals(10, $sizeCollection);

		$aTitleData = $collection[0];
		$this->assertEquals('Apples', $aTitleData->pieceFirst);

		$aTitleData = $collection[1];
		$this->assertEquals('Apples', $aTitleData->pieceFirst);

		$aTitleData = $collection[2];
		$this->assertEquals('Base', $aTitleData->pieceFirst);

		$aTitleData = $collection[3];
		$this->assertEquals('Cats', $aTitleData->pieceFirst);

		$aTitleData = $collection[4];
		$this->assertEquals('Dance', $aTitleData->pieceFirst);

		$aTitleData = $collection[5];
		$this->assertEquals('Point', $aTitleData->pieceFirst);

		$aTitleData = $collection[6];
		$this->assertEquals('View', $aTitleData->pieceFirst);

		$aTitleData = $collection[7];
		$this->assertEquals('View', $aTitleData->pieceFirst);

		$aTitleData = $collection[8];
		$this->assertEquals('Zen', $aTitleData->pieceFirst);

		$aTitleData = $collection[9];
		$this->assertEquals('Zen', $aTitleData->pieceFirst);







	}



	public function testGetTdc()
	{
		$this->markTestSkipped('TODO - need to implement testGetTdc');
	}

	public function testFindRange()
	{
		$objTDC = new TitleDataCollection();

		$sizeLinesx10 = count($this->linesx10);

		for ($i=0; $i < $sizeLinesx10; $i++)
		{
			$objTD = new TitleData();
			$aLine = $this->linesx10[$i];
			$objTD->getPieces($aLine, $i);
			$objTDC->add($objTD);
		}

		$objTDC->sort();


		// public function quickFind($property, $value_to_find, &$first_index)
		$property = 'pieceFirst';
		$firstIndex = -1; // @todo noted set to non valid index
		$found = $objTDC->quickFind($property, 'Cats', $firstIndex);
		$this->assertEquals(3, $firstIndex);
		$this->assertTrue($found);
		$property = 'pieceFirst';
		$minIndex = -1;
		$maxIndex = -1;
		$objTDC->findRange($firstIndex, $property, $minIndex, $maxIndex);
		echo 'minIndex = '.$minIndex."\n";
		echo 'maxIndex = '.$maxIndex."\n";

		$tdcCollection = $objTDC->getTdc();
		$sizeTdcCollection = count($tdcCollection);
		for ($j= 0; $j < $sizeTdcCollection; $j++)
		{
			$pf = $tdcCollection[$j]->pieceFirst;
			echo '... pf='.$pf."\n";
		}
		$this->assertEquals(3 , $minIndex);
		$this->assertEquals(3 , $maxIndex);
	}

	public function testLinkx10()
	{
		$objTDC = new TitleDataCollection();

		$sizeLinesx10 = count($this->linesx10);

		for ($i=0; $i < $sizeLinesx10; $i++)
		{
			$objTD = new TitleData();
			$aLine = $this->linesx10[$i];
			$objTD->getPieces($aLine, $i);
			$objTDC->add($objTD);
		}

		$objTDC->sort();
		$sorted = $objTDC->getSorted();
		$this->assertTrue($sorted);
		$linked = $objTDC->link();

		$this->assertTrue($linked);

		$tdcCollection = $objTDC->getTdc();

		$nextCt = count($tdcCollection[0]->next);
		if ($tdcCollection[0]->pieceLast == 'Zen')
		{
			$this->assertEquals(2, $nextCt);
		}
		else 
		{
			if ($tdcCollection[0]->pieceLast == 'Xerox')
			{
				$this->assertEquals(0, $nextCt);	
			}
		}

		// The one with first of Base should have two Apples.
		$nextCt = count($tdcCollection[2]->next);
		$this->assertEquals(2, $nextCt);

		// The one with first of Zen should have 0 next entries.
		$nextCt = count($tdcCollection[8]->next);
		$this->assertEquals(0, $nextCt);

		// Another one with first of Zen should have 0 next entries.
		$nextCt = count($tdcCollection[9]->next);
		$this->assertEquals(0, $nextCt);
		

	}

	/**
	  * A test with only 5 lines, each with unique first values.
	  * Each line has a last value that matches the first value
	  * of only one other line.
	  */
	public function testLinkx5()
	{
		$objTDC = new TitleDataCollection();

		$sizeLinesx5 = count($this->linesx5);

		for ($i=0; $i < $sizeLinesx5; $i++)
		{
			$objTD = new TitleData();
			$aLine = $this->linesx5[$i];
			$objTD->getPieces($aLine, $i);
			$objTDC->add($objTD);
		}

		$objTDC->sort();
		$sorted = $objTDC->getSorted();
		$this->assertTrue($sorted);
		$linked = $objTDC->link();

		$this->assertTrue($linked);

		$tdcCollection = $objTDC->getTdc();

		$nextCt = count($tdcCollection[0]->next);
		// @todo more here

		/*
		 * Recursively explore the chain of TitleData
		 * via the next component, and make sure the first
		 * piece matches the expected value.
		 */
		$i = 0;
		
		$curTitleData = $tdcCollection[0];
		$first = $curTitleData->pieceFirst;
		$last = $curTitleData->pieceLast;

		$this->assertEquals($this->expectedPieceFirstx5[$i], $first); 
		while ((count($curTitleData->next) == 1) && ($i <= 4))
		{
			$curTitleData = $curTitleData->next[0];;
			$i++;
			$first = $curTitleData->pieceFirst;
			$last = $curTitleData->pieceLast;

			$this->assertEquals($this->expectedPieceFirstx5[$i], $first); 
		}
	}
	
	/**
	  * A test with only 20 lines, generated automatically.
	  * This is the first of the auto generated file tests.
	  *
	  * @todo finish this.
	  */
	public function testLinkx20autogenerate()
	{
		echo 'testLinkx20autogenerate-start'."\n";
		$objTDC = new TitleDataCollection();

		$numLines = 20;
		$fileName = 'test-linkx-20-auto-generate.tsv';

		/* @todo determine if fileName exists */
		$fileExists = file_exists($fileName);
		if ($fileExists)
		{
			$now = date('Ymd-H:i:s');
			rename($fileName, $fileName.'.'.$now);
		}

	    $originalExceptions = array();
	    $originalExceptions[4] = array('start'=>'CAA', 'end'=>'HAA');
	    $originalExceptions[6] = array('start'=>'HAA', 'end'=>'FII');
	    $originalExceptions[8] = array('start'=>'FII', 'end'=>'GYM');
	  
        $originalExceptions[15] = array('start'=>'HAA', 'end'=>'HEE');
	    $originalExceptions[16] = array('start'=>'HAA', 'end'=>'FEE');
	    $originalExceptions[17] = array('start'=>'HAA', 'end'=>'REE');

		$createAttributes = TitleDataFileCreateAttributes::makeN($numLines, $fileName, $originalExceptions);
		$retCreate = TitleUtilities::createTitleDataFile($createAttributes);
		if ($retCreate == FALSE)
		{
			// failure in test.
			// @todo
		}

		// $sizeLinesx5 = count($numLines);

		$handle = fopen($fileName, 'r');

		if ($handle == FALSE)
		{
			throw new Exception('Unable to fopen:'.$fileName);
		}
		$linesRead = 0;
		$currentLine = fgets($handle);
		while ($currentLine != FALSE)
		{
			$linePieces = explode("\t", $currentLine);
			$objTD = new TitleData();
			$objTD->getPieces($currentLine, $linesRead);
			$objTDC->add($objTD);
			$currentLine = fgets($handle);
		}
		$objTDC->sort();
		$sorted = $objTDC->getSorted();
		$this->assertTrue($sorted);
		$linked = $objTDC->link();

		$this->assertTrue($linked);

		$tdcCollection = $objTDC->getTdc();

		/*
		 * The original exceptions should be placed near the end of the sorted
		 * array, because the non-exceptions all begin with A*.
		 * They are found at index 14-19 inclusive, which is 6 elements.
		 */
		$nextCt = count($tdcCollection[14]->next);
		echo '...nextCt='.$nextCt."\n";
		echo '...14th..pieceFirst..='.$tdcCollection[14]->pieceFirst."\n";
		if ($tdcCollection[14]->pieceFirst == 'CAA')
		{
			echo '... doing the assert with 4 and nextCt'."\n";
			$this->assertEquals(4, $nextCt);
		}

		/*
		 * The first 14 elements (with index 0 to 13 inclusive) in the sorted
		 * array should be ones that are autogenerated.  Those elements
		 * should not have any participation in the longest title.
		 * They are all unique start and end.  There is not opportunity
		 * for linking with that set of elements.
		 *
		 * Accordingly, the next and previous arrays, which contain references
		 * to linked other titles, should all be of length 0.
		 *
		 * The following code tests are assumption to make sure the algorithm
		 * is working properly.
		 */
		for ($i = 0; $i <= 13; $i++)
		{
			$nCt = count($tdcCollection[$i]->next);
			$this->assertEquals(0, $nCt);
			$pCt = count($tdcCollection[$i]->prev);
			$this->assertEquals(0, $pCt);
		}

		/*
		 * Now lets explore if the longest title can be identified.
		 * @todo
		 */

		fclose($handle);
		echo 'testLinkx20autogenerate-end'."\n";

	}

	/**
	  * A test with 2000 lines, generated automatically.
	  * This is the second of the auto generated file tests.
	  *
	  * @todo finish this.
	  */
	public function testLinkx2000autogenerate()
	{
		echo 'testLinkx2000autogenerate-start'."\n";
		$objTDC = new TitleDataCollection();

		$numLines = 2000;
		$fileName = 'test-linkx-2000-auto-generate.tsv';

		/* @todo determine if fileName exists */
		$fileExists = file_exists($fileName);
		if ($fileExists)
		{
			$now = date('Ymd-H:i:s');
			rename($fileName, $fileName.'.'.$now);
		}

		/**
		  * @note Original Exceptions will product the longest title of:
		  * MAA - NAA - OAA -- PAA -- QAA - RAA 
		  */
	    $originalExceptions = array();
	    $originalExceptions[4] = array('start'=>'MAAAA', 'end'=>'NAAAA');
	    $originalExceptions[6] = array('start'=>'OAAAA', 'end'=>'PAAAA');
	    $originalExceptions[8] = array('start'=>'RAAAA', 'end'=>'SAAAA');
	  
        $originalExceptions[15] = array('start'=>'NAAAA', 'end'=>'OAAAA');
	    $originalExceptions[16] = array('start'=>'PAAAA', 'end'=>'QAAAA');
	    $originalExceptions[17] = array('start'=>'QAAAA', 'end'=>'RAAAA');

		$createAttributes = TitleDataFileCreateAttributes::makeN($numLines, $fileName, $originalExceptions);
		$retCreate = TitleUtilities::createTitleDataFile($createAttributes);
		if ($retCreate == FALSE)
		{
			// failure in test.
			// @todo
		}


		$handle = fopen($fileName, 'r');

		if ($handle == FALSE)
		{
			throw new Exception('Unable to fopen:'.$fileName);
		}
		$linesRead = 0;
		$currentLine = fgets($handle);
		while ($currentLine != FALSE)
		{
			$linePieces = explode("\t", $currentLine);
			$objTD = new TitleData();
			$objTD->getPieces($currentLine, $linesRead);
			$objTDC->add($objTD);
			$currentLine = fgets($handle);
		}
		$objTDC->sort();
		$sorted = $objTDC->getSorted();
		$this->assertTrue($sorted);
		$linked = $objTDC->link();

		$this->assertTrue($linked);

		$tdcCollection = $objTDC->getTdc();

		/*
		 * The original exceptions should be placed near the end of the sorted
		 * array, because the non-exceptions all begin with A*.
		 * They are found at index 1994-1999 inclusive, which is 6 elements.
		 */
		$nextCt = count($tdcCollection[1994]->next);
		echo '...nextCt='.$nextCt."\n";
		echo '...1994th..pieceFirst..='.$tdcCollection[1994]->pieceFirst."\n";
		if ($tdcCollection[1994]->pieceFirst == 'MAAAA')
		{
			echo '... doing the assert with 1 and nextCt'."\n";
			$this->assertEquals(1, $nextCt);
		}

		/*
		 * The first 1994 elements (with index 0 to 1993 inclusive) in the sorted
		 * array should be ones that are autogenerated.  Those elements
		 * should not have any participation in the longest title.
		 * They are all unique start and end.  There is no opportunity
		 * for linking with that set of elements.
		 *
		 * Accordingly, the next and previous arrays, which contain references
		 * to linked other titles, should all be of length 0.
		 *
		 * The following code tests are assumption to make sure the algorithm
		 * is working properly.
		 */
		for ($i = 0; $i <= 1993; $i++)
		{
			$nCt = count($tdcCollection[$i]->next);
			$this->assertEquals(0, $nCt);
			$pCt = count($tdcCollection[$i]->prev);
			$this->assertEquals(0, $pCt);
		}

		/*
		 * Now lets explore if the longest title can be identified.
		 * @todo
		 */

		fclose($handle);
		echo 'testLinkx2000autogenerate-end'."\n";

	}

	public function testIntersect()
	{
		echo 'testIntersect-start'."\n";
		$objTDC1 = new TitleDataCollection();

		$sizeLinesx7 = count($this->linesx7);

		for ($i=0; $i < $sizeLinesx7; $i++)
		{
			$objTD = new TitleData();
			$aLine = $this->linesx7[$i];
			$objTD->getPieces($aLine, $i);
			$objTDC1->add($objTD);
		}

		// tdc1 is a reference to the internal array of objTDC1.
		$tdc1 = $objTDC1->getTdc();

		$tdc1Clone = clone $tdc1;
		$tdc1DeepCopy = TestUtilities::deepCopy($tdc1Clone);

		$objTDC2 = new TitleDataCollection();
		$tdc2 = $objTDC2->getTdc();
		// Now tdc2 is just an alias for the tdc in our second collection.
		// And adjust it as follows.
		$tdc2 = $tdc1DeepCopy;


		$objTDCIntersect = TitleDataCollection::intersect($objTDC1, $objTDC2);

		echo 'testIntersect-end'."\n";
	}

	public function testCloneUsage()
	{
	}



}
?>

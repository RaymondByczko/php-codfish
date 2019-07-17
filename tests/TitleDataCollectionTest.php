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
  */
use PHPUnit\Framework\TestCase;
use RaymondByczko\PhpCodfish\TitleData;
use RaymondByczko\PhpCodfish\TitleDataCollection;

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
		$objTDC = new TitleDataCollection();

		$numLines = 20;
		$fileName = 'test-linkx-20-auto-generate.tsv';
		/* @todo determine if fileName exists */
	    $originalExceptions = array();
	    $originalExceptions[4] = array('start'=>'CA', 'end'=>'HA');
	    $originalExceptions[6] = array('start'=>'HA', 'end'=>'FI');
	    $originalExceptions[8] = array('start'=>'FI', 'end'=>'GYMM');
	  
        $originalExceptions[15] = array('start'=>'HA', 'end'=>'HE');
	    $originalExceptions[16] = array('start'=>'HA', 'end'=>'FE');
	    $originalExceptions[17] = array('start'=>'HA', 'end'=>'RE');

		$createAttributes = TitleDataFileCreateAttributes::makeN($numLines, $fileName, $originalExceptions);
		$objTDC = TitleUtilities::createTitleDataFile($createAttributes);

		$sizeLinesx5 = count($this->linesx5);

		for ($i=0; $i < $sizeLinesx5; $i++)
		{
			$objTD = new TitleData();
			$aLine = $this->linesx5[$i];
			$objTD->getPieces($aLine, $i);
			$objTDC->add($objTD);
		}



}
?>

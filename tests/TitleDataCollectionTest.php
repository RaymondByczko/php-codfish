<?php
//namespace tests;
use PHPUnit\Framework\TestCase;
use RaymondByczko\PhpCodfish\TitleData;
use RaymondByczko\PhpCodfish\TitleDataCollection;

class TitleDataCollectionTest extends TestCase
{
	protected $linesx10 = array(
		't01	short	Apples of Zen	Apples of Zen	0	1994	\N	1	Documentary',
		't02	short	Zen in Net	Zen in Net	0	1892	\N	5	Animation',
		't03	short	Zen of Met	Zen of Met	0	1892	\N	4	Animation',
		't04	short	Cats of Xerox	Apples of Xerox	0	1992	\N	\N	Animation',
		't05	short	Base of Apples	Base of Apples	0	1993	\N	1	Comedy',
		't06	short	Point of View	Point of View	0	1994	\N	1	Short',
		't07	short	Dance of Apples	Dance of Apples	0	1994	\N	1	Sport',
		't08	short	Cats of Wales	Cats of Wales	0	1994	\N	1	Documentary',
		't09	movie	View of Apples	View of Apples	0	1995	\N	45	Romance',
		't10	short	View of Zen	View of Zen	0	1995	\N	1	Documentary'
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
		// $this->assertEquals(3, $firstIndex);
		$this->assertTrue((2==$firstIndex)||(3==$firstIndex));
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
		$this->assertEquals(2 , $minIndex);
		$this->assertEquals(3 , $maxIndex);
	}

}
?>
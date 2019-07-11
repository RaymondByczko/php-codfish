<?php
/**
  * @file TitleUtilitiesTest.php
  * @location php-codfish/tests
  * @company self
  * @author Raymond Byczko
  * @start_date 2019-07-10
  * @history 2019-07-10; RByczko; 
  */
use PHPUnit\Framework\TestCase;
use RaymondByczko\PhpCodfish\TitleUtilities;
use RaymondByczko\PhpCodfish\TitleDataFileCreateAttributes;

class TitleUtilitiesTest extends TestCase
{
	public function testSomething()
	{
		$createAttributes = new TitleDataFileCreateAttributes();
		$objTDC = TitleUtilities::createTitleDataFile(TitleDataFileCreateAttributes $createAttributes);
	}
}
?>

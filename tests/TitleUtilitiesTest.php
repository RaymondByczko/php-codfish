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
	public function testCreateTitleDataFileDefault()
	{
		$createAttributes = new TitleDataFileCreateAttributes();
		$objTDC = TitleUtilities::createTitleDataFile($createAttributes);
	}

	public function testCreateTitleDataFile500()
	{
		$createAttributes = TitleDataFileCreateAttributes::make500();
		$objTDC = TitleUtilities::createTitleDataFile($createAttributes);
	}
}
?>

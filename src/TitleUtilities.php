<?php
/**
  * @file TitleUtilities.php
  * @location php-codfish/src/
  * @author Raymond Byczko
  * @history 2019-07-09;RByczko;Added createTitleDataFile.
  * @history 2019-07-24;RByczko;Added deepCopy.
  */

namespace RaymondByczko\PhpCodfish;

use RaymondByczko\PhpCodfish\TitleDataFileCreateAttributes;

class TitleUtilities
{
	/**
	  * Given some collection title data, and perhaps optional out1 and out2 strings, this method
	  * just echos out the pieceFirst and pieceLast properties of each.  This particular
	  * method is not generalized.  Rather it is refactoring of some initial debugging
	  * code. It may not be generally useful.  Client code can be more tidy.
	  */
	public static function printCollection($collectionTitleData, $out1='collectionTitleData: before sort'."\n", $out2='...FIRST'."\n")
	{
		echo $out1;
		echo $out2;
		foreach ($collectionTitleData as $key=>$aTitleData)
		{
			echo '... ... aTitleData: '.$key.' '.$aTitleData->pieceFirst.' ,'.$aTitleData->pieceLast."\n";
		}
	}

	public static function createTitleDataFile(TitleDataFileCreateAttributes $createAttributes)
	{
		$retCreate = $createAttributes->create();
		return $retCreate;
	}


	/**
	  * This deepCopy was obtained from the following website.
	  * https://abiusx.com/a-rigorous-study-of-deep-copy-in-php/
	  * Albiet with limitation, it seems to work.  It was tried
	  * in misc/arrayobjectcopy02.php .
	  */
	public static function deepCopy(&$variable)
	{
		return unserialize(serialize($variable));
	}
}
?>

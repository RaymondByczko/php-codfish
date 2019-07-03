<?php
namespace RaymondByczko\PhpCodfish;

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
		foreach ($CollectionTitleData as $key=>$aTitleData)
		{
			echo '... ... aTitleData: '.$key.' '.$aTitleData->pieceFirst.' ,'.$aTitleData->pieceLast."\n";
		}
	}
}
?>

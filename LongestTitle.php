<?php
/**
 * PHPDoc DocBlock for file.
 * @file LongestTitle.php
 * @company self
 * @author Raymond Byczko
 * @history 2019-06-28; RByczko; Added compareFirst, compareLast to class TitleData.
 * @history 2019-06-29; RByczko; Moved TitleExcluded class to its own file.
 * @history 2019-06-29; RByczko; Moved TitleData class to its own file. Adjust for autoload.
 * @history 2019-06-29; RByczko; Moved TitleDataFileFormat class to its own file.
 * @history 2019-06-29; RByczko; No need to require autoload.php in this file.
 * @history 2019-06-29; RByczko; uasort needs fully named class name, and the static method
 * utilized, to work well.
 *
 */

// require __DIR__.'/vendor/autoload.php';
use RaymondByczko\PhpCodfish\TitleData;
use RaymondByczko\PhpCodfish\TitleDataFileFormat;

echo 'NEWLINE'."\n";
$line1 = "tt0000001	short	Carmencita	Carmencita	0	1894	\N	1	Documentary,Short";
$line1Pieces = explode("\t", $line1);
foreach ($line1Pieces as $piece)
{
	echo 'piece is:'.$piece."\n";
}

echo 'NEWLINE'."\n";
$line2 = "tt0000002	short	Le clown et ses chiens	Le clown et ses chiens	0	1892	\N	5	Animation,Short";

$line2Pieces = explode("\t", $line2);
foreach ($line2Pieces as $piece)
{
	echo 'piece is:'.$piece."\n";
}


$fileMovieData = 'smalldata2.tsv';
$hMovieData = fopen($fileMovieData, "r");
if ($hMovieData == FALSE)
{
	throw new Exception('Unable to fopen:'.$fileMovieData);
}

$collectionTitleData = array();
$linesRead = 0;

$currentLine = fgets($hMovieData);
while ($currentLine != FALSE)
{
	$linesRead++;
	echo 'NEWLINE'."\n";
	$linePieces = explode("\t", $currentLine);
	foreach ($linePieces as $piece)
	{
		echo '...piece is:'.$piece."\n";
	}

	$originalTitle = $linePieces[TitleDataFileFormat::$c_originalTitle];
	echo '...originalTitle='.$originalTitle."\n";
	$titlePieces = explode(' ', $originalTitle);
	$titlePieceFirst = $titlePieces[0];
	$titlePieceLast = $titlePieces[count($titlePieces) -1 ];

	$objTitleData = new TitleData();
	$objTitleData->getPieces($currentLine, $linesRead);
	$collectionTitleData[] = $objTitleData;
	// $collectionTitleData[] = &$objTitleData;

	$currentLine = fgets($hMovieData);
}

$sizeColTitleData = count($collectionTitleData);

$fCollectionTitleData = $collectionTitleData;
$lCollectionTitleData = $collectionTitleData;

echo 'sizeColTitleData='.$sizeColTitleData."\n";
echo '... 0th first Piece: '.$collectionTitleData[0]->pieceFirst."\n";
echo '... 5th first Piece: '.$collectionTitleData[5]->pieceLast."\n";

echo 'collectionTitleData: before sort'."\n";
echo '...FIRST'."\n";
foreach ($fCollectionTitleData as $key=>$aTitleData)
{
	echo '... ... aTitleData: '.$key.' '.$aTitleData->pieceFirst.' ,'.$aTitleData->pieceLast."\n";
}

echo '...LAST'."\n";
foreach ($lCollectionTitleData as $key=>$aTitleData)
{
	echo '... ... aTitleData: '.$key.' '.$aTitleData->pieceFirst.' ,'.$aTitleData->pieceLast."\n";
}



// usort($collectionTitleData, array("TitleData", "compareFirst"));
uasort($fCollectionTitleData, array("RaymondByczko\PhpCodfish\TitleData", "compareFirst"));
uasort($lCollectionTitleData, array("RaymondByczko\PhpCodfish\TitleData", "compareLast"));

echo 'collectionTitleData: post sort (first)'."\n";
echo '...FIRST'."\n";
foreach ($fCollectionTitleData as $key=>$aTitleData)
{
	echo '... ... aTitleData: '.$key.' '.$aTitleData->pieceFirst.' ,'.$aTitleData->pieceLast."\n";
}

echo '...LAST'."\n";
foreach ($lCollectionTitleData as $key=>$aTitleData)
{
	echo '... ... aTitleData: '.$key.' '.$aTitleData->pieceFirst.' ,'.$aTitleData->pieceLast."\n";
}




fclose($hMovieData);

/**
  * @todo Use usort with user-defined compare function to make $collectionTitleData
  * in order.  Make it order by pieceFirst.  A second copy of the array could be
  * sorted by pieceLast.
  * This will help create links use php references since the first array will be
  * sorted by pieceFirst.  Look in second array which is sorted on pieceLast for
  * where the match occurs.  Then set up the links.
  */


?>


<?php
/**
 * PHPDoc DocBlock for file.
 * @file LongestTitle.php
 * @company self
 * @author Raymond Byczko
 * @documentation
 * 
 * The main idea of this implementation is to establish links between one title and its successor.
 * Further, a link will be set between a title and its predeccesor.
 * So, basically in place, these links will be set up, and only the prev, next links are adjusted.
 *
 * How can this work?
 *
 * Lets assume very simple titles with no excluded words.
 * Lets assume each title is composed of two words, each word is a character.
 *
 * A Z
 * Z N
 * Z M
 * A X
 * B A
 * P V
 * D A
 * C W
 * V A
 * V Z
 *
 * So the first title is 'A Z', and the last title is 'V Z'.  'A Z' will link with
 * 'Z N' and 'Z M'.  The following would be produced with those three titles:
 * 'A Z N', 'A Z M'.
 * 
 * To allow this occur, 'A Z', needs to find the 'Z N', and Z M' elements.
 * For very large arrays, do we want to search looking for the initial Z?
 * Or how do we want to search?
 *
 * Further, 'A Z' is not the only element interested in 'Z N' and 'Z M'.
 * It turns out 'V Z' is also interested.
 *
 * To allow efficient search, we can a) sort on the first letter b) sort on the last
 * letter.  Then we can do an implementation of quick sort.  Although it doubles
 * memory allocation, the initial array can be copied, and both can be sorted.
 *
 * Here is the result with our sample data.
 *
SORT ON FIRST
A Z
A X
B A
C W
D A
P V
V A
V Z
Z N
Z M

SORT ON LAST
D A
B A
V A
Z M
Z N
P V
C W
A X
A Z
V Z





 * @history 2019-06-28; RByczko; Added compareFirst, compareLast to class TitleData.
 * @history 2019-06-29; RByczko; Moved TitleExcluded class to its own file.
 * @history 2019-06-29; RByczko; Moved TitleData class to its own file. Adjust for autoload.
 * @history 2019-06-29; RByczko; Moved TitleDataFileFormat class to its own file.
 * @history 2019-06-29; RByczko; No need to require autoload.php in this file.
 * @history 2019-06-29; RByczko; uasort needs fully named class name, and the static method
 * utilized, to work well.
 * @history 2019-06-29; RByczko; Removed code fragment exploring explode.  Moved to misc/explode01.php.
 * @history 2019-07-01; RByczko; Moved debugging type code to its own utility.  Took care of presort.
 * @history 2019-07-01; RByczko; Moved debugging type code to its own utility.  Took care of postsort.
 * @history 2019-07-03; RByczko; Added documentation above (draft).
 *
 */

// require __DIR__.'/vendor/autoload.php';
use RaymondByczko\PhpCodfish\TitleData;
use RaymondByczko\PhpCodfish\TitleDataFileFormat;
use RaymondByczko\PhpCodfish\TitleUtilities;



$fileMovieData = 'testdata/data10.tsv';
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

// Inspect fCollectionTitleData, per debugging.
TitleUtilities::printCollection($fCollectionTitleData, 'collectionTitleData: before sort'."\n", '...FIRST'."\n");
// Inspect lCollectionTitleData, per debugging.
TitleUtilities::printCollection($lCollectionTitleData, 'collectionTitleData: before sort'."\n", '...LAST'."\n");


// usort($collectionTitleData, array("TitleData", "compareFirst"));
uasort($fCollectionTitleData, array("RaymondByczko\PhpCodfish\TitleData", "compareFirst"));
uasort($lCollectionTitleData, array("RaymondByczko\PhpCodfish\TitleData", "compareLast"));


// Inspect fCollectionTitleData, per debugging.
TitleUtilities::printCollection($fCollectionTitleData, 'collectionTitleData: post sort'."\n", '...FIRST'."\n");
// Inspect lCollectionTitleData, per debugging.
TitleUtilities::printCollection($lCollectionTitleData, 'collectionTitleData: post sort'."\n", '...LAST'."\n");


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


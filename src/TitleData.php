<?php
/**
  * @file TitleData.php
  * @location php-codfish/src/
  * @author Raymond Byczko
  * @history 2019-07-04;RByczko;Added assignment to $line_num in
  * method getPieces.
  * @history 2019-07-23;RByczko;Added compareLastFirst.
  */
namespace RaymondByczko\PhpCodfish;

class TitleData
{
	public $pieceFirst;
	public $pieceLast;

	public $prev;
	public $next;

	public $line_num;
	public function __construct(/*$pieceFirst, $pieceLast*/)
	{
		// $this->pieceFirst = $pieceFirst;
		// $this->pieceLast =	$pieceLast;

		$this->line_num = -1;
		$this->prev = array();
		$this->next = array();
	}
	public function getPieces($a_line, $line_number)
	{
		$linePieces = explode("\t", $a_line);
		foreach ($linePieces as $piece)
		{
			echo '...piece is:'.$piece."\n";
		}

		$originalTitle = $linePieces[TitleDataFileFormat::$c_originalTitle];
		echo '...originalTitle='.$originalTitle."\n";
		$titlePieces = explode(' ', $originalTitle);

		/**
		 * @todo Need to use TitleExcluded to find titles that begin with
		 * known excluded words.
		 */
		$titlePieceFirst = $titlePieces[0];
		$titlePieceLast = $titlePieces[count($titlePieces) -1 ];

		$this->pieceFirst = $titlePieceFirst;
		$this->pieceLast = $titlePieceLast;

		$this->line_num = $line_number;
		
	}

	public static function compareFirst(TitleData $a, TitleData $b)
	{
		if ($a->pieceFirst == $b->pieceFirst)
		{
			return 0;
		}
		return ($a->pieceFirst < $b->pieceFirst)?-1:1;
	}

	public static function compareLast(TitleData $a, TitleData $b)
	{
		if ($a->pieceLast == $b->pieceLast)
		{
			return 0;
		}
		return ($a->pieceLast < $b->pieceLast)?-1:1;
	}

	/**
	  * This is used to compare two arrays, one is sorted on the last value, and
	  * the second is sorted on the first value.
	  *
	  *	This method is chiefly intended for: array_uintersect_uassoc
	  * An intersection of two arrays would be found using this compare method.
	  */
	public static function compareLastFirst(TitleData $a, TitleData $b)
	{
		if ($a->pieceLast == $b->pieceFirst)
		{
			return 0;
		}
		return ($a->pieceLast < $b->pieceFirst)?-1:1;

	}

}
?>

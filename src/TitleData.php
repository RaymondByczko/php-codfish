<?php
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

}
?>

<?php
/**
  * @file TitleDataFileCreateAttributes.php
  * @location php-codfish/src/
  * @author Raymond Byczko
  * @history 2019-07-09;RByczko;Created this file.
  * @history 2019-07-15;RByczko;Added documentation to this file.
  * Renamed variable titlePrimaryTypeStart to titlePrimaryTitleStart.
  * Renamed variable titlePrimaryTypeEnd to titlePrimaryTitleEnd.
  */

namespace RaymondByczko\PhpCodfish;

class TitleDataFileCreateAttributes
{
	public $numLines = 0;
	public $fileName = NULL;
	public $mode = '';


	/**
	  * The following are from the following class:
	  * class TitleDataFileFormat
	  * See file: TitleDataFileFormat.php
	  * @note This file needs to be hand synchronized with
	  * TitleDataFileFormat.php
	  * @important This file needs to be hand synchronized with
	  * TitleDataFileFormat.php
	  */
	/**
	  * Contains the prefix to build the tconst.  A number string
	  * is appended to it to make it unique.
	  */
	public $titleTconstPrefix;
	/**
	  * Contains the type of the film entry.  It can be 'short' or 'movie'
	  * for example.
	  */
	public $titleType;
	/**
	  * Contains the PREFIX for the start word for the primary title.  A number
	  * string is appended to this to generate the full start word of the
	  * primary title.
	  */
	public $titlePrimaryTitleStart;
	/**
	  * Contains the PREFIX for the end word for the primary title.  A number
	  * string is appended to this to generate the full end word of the
	  * primary title.
	  */
	public $titlePrimaryTitleEnd;
	/* ----- */
	/**
	  * The full primary title is composed of two words with an intervening
	  * space. These words are labelled as 'start' and 'end'.  Each of these
	  * is comprised of a prefix value to which a number is appended.
	  *
	  * This makes for boring but easy to generate, trace and follow primary titles
	  * that can be tested, because their properties are well known and predictable.
	  */
	/* ----- */

	/**
	  * Contains the PREFIX for the start word of the original title.  A number
	  * string is appended to this to generate the start word of the original title.
	  */
	public $titleOriginalTitleStart;
	/**
	  * Contains the PREFIX for the end word of the original title.  A number
	  * string is appended to this to generate the end word of the original title.
	  */
	public $titleOriginalTitleEnd;

	/* ----- */
	/**
	  * The full original title is composed of two words with an intervening space.
	  * Its the same as with the primary title described above.  Apply the same
	  * construction process there to here.
	  */
	/* ----- */

	/**
	  * Specifies whether the movie specified is for adults or not.
	  */
	public $titleAdult;
	/**
	  * Specifies the start year for the movie.
	  */
	public $titleStartYear;
	/**
	  * Specifies the end year for the movie.  "\N" is often specified
	  * for this.
	  */
	public $titleEndYear;
	/**
	  * The length of the film in minutes.
	  */
	public $titleRunTimeMinutes;
	/**
	  * The genre(s) this movie fits into.  If it is more than, seperate
	  * the individual genre with commas.
	  */
	public $titleGenres;

	/**
	  * An array of arrays.  The initial array is index via number. Each element
	  * of that array is an associative array.  The keys of that associate array
	  * are 'start' and 'end'.
	  *
	  * This code file helps specify the attributes of a data file that is automatically
	  * created.  This is useful for large files which would be difficult to do by hand.
	  */
	public $originalExceptions;

	public function __construct()
	{
		$this->numLines = 1000;
		$this->fileName = 'test1000.tsv';
		$this->mode = 'w+';

		$this->titleTconstPrefix = 'tt';
		$this->titleType = 'short';
		$this->titlePrimaryTitleStart = 'A';
		$this->titlePrimaryTitleEnd = 'E';
		$this->titleOriginalTitleStart = 'A';
		$this->titleOriginalTitleEnd = 'E';
		$this->titleAdult = 0;
		$this->titleStartYear = 2019;
		$this->titleEndYear = 2019;
		$this->titleRunTimeMinutes = 60;
		$this->titleGenres = 'Documentary';

		$this->originalExceptions = array();
		$this->originalExceptions[5] = array('start'=>'A0011', 'end'=>'A0012');

		$this->originalExceptions[6] = array('start'=>'CATTT', 'end'=>'HATTT');
		$this->originalExceptions[8] = array('start'=>'HATTT', 'end'=>'FITSS');


	}

	static public function make500()
	{
		$newObject = new TitleDataFileCreateAttributes();

		$newObject->numLines = 500;
		$newObject->fileName = 'test500.tsv';
		$newObject->mode = 'w+';

		$newObject->titleTconstPrefix = 'tt';
		$newObject->titleType = 'short';
		$newObject->titlePrimaryTitleStart = 'A';
		$newObject->titlePrimaryTitleEnd = 'E';
		$newObject->titleOriginalTitleStart = 'A';
		$newObject->titleOriginalTitleEnd = 'E';
		$newObject->titleAdult = 0;
		$newObject->titleStartYear = 2019;
		$newObject->titleEndYear = 2019;
		$newObject->titleRunTimeMinutes = 60;
		$newObject->titleGenres = 'Documentary';

		$newObject->originalExceptions = array();

		/**
		  * values at start, end keys are 4 characters in length.
		  * This gives a nice presentation when strlen('A') + strlen('500') == 4.
		  */
		$newObject->originalExceptions[6] = array('start'=>'CATT', 'end'=>'HATT');
		$newObject->originalExceptions[8] = array('start'=>'HATT', 'end'=>'FITT');
		$newObject->originalExceptions[10] = array('start'=>'FITT', 'end'=>'GYMM');


		$newObject->originalExceptions[20] = array('start'=>'HATT', 'end'=>'HEAD');
		$newObject->originalExceptions[21] = array('start'=>'HATT', 'end'=>'FELL');
		$newObject->originalExceptions[22] = array('start'=>'HATT', 'end'=>'REDD');
		
		return $newObject;


	}

	/**
	  * numLines = 20
	  * fileName = test20.tsv
	  * originalExceptions = array();
	  *	originalExceptions[6] = array('start'=>'CATT', 'end'=>'HATT');
	  *	originalExceptions[8] = array('start'=>'HATT', 'end'=>'FITT');
	  *	originalExceptions[10] = array('start'=>'FITT', 'end'=>'GYMM');
	  *
      *	originalExceptions[20] = array('start'=>'HATT', 'end'=>'HEAD');
	  *	originalExceptions[21] = array('start'=>'HATT', 'end'=>'FELL');
	  *	originalExceptions[22] = array('start'=>'HATT', 'end'=>'REDD');
	  */
	static public function makeN($numLines, $fileName, $originalExceptions)
	{
		$newObject = new TitleDataFileCreateAttributes();

		$newObject->numLines = $numLines;
		$newObject->fileName = $fileName;
		$newObject->mode = 'w+';

		$newObject->titleTconstPrefix = 'tt';
		$newObject->titleType = 'short';
		$newObject->titlePrimaryTitleStart = 'A';
		$newObject->titlePrimaryTitleEnd = 'E';
		$newObject->titleOriginalTitleStart = 'A';
		$newObject->titleOriginalTitleEnd = 'E';
		$newObject->titleAdult = 0;
		$newObject->titleStartYear = 2019;
		$newObject->titleEndYear = 2019;
		$newObject->titleRunTimeMinutes = 60;
		$newObject->titleGenres = 'Documentary';

		$newObject->originalExceptions = $originalExceptions;
		
		return $newObject;


	}


	/**
	  * Creates a file with orderly data, that in general, is not 'linkable'. The
	  * end value of each 'title' will not match the start value of any other 'title'.
	  * Thus most of the data is 'bulk filler' which helps test the algorith under
	  * larger data sizes. The property originalExceptions is used to create 'linkable'
	  * elements.
	  */
	public function create()
	{
		$handle = fopen($this->fileName, $this->mode);
		if ($handle == FALSE)
		{
			echo '... returning FALSE'."\n";
			return FALSE;
		}
		$iStrLen = strlen($this->numLines);
		for ($i = 0; $i < $this->numLines; $i++)
		{
			// $iStr = strval($i);
			// $iStrLen = strlen($iStr);

			$iFormatted = sprintf("%0".$iStrLen."d", $i);

			$lineOutput = '';
			$lineOutput .= $this->titleTconstPrefix;
			$lineOutput .= $iFormatted;
			$lineOutput .= "\t";
			$lineOutput .= $this->titleType;
			$lineOutput .= "\t";
			$lineOutput .= $this->titlePrimaryTitleStart;
			$lineOutput .= $iFormatted;
			$lineOutput .= ' ';
			$lineOutput .= $this->titlePrimaryTitleEnd;
			$lineOutput .= $iFormatted;
			$lineOutput .= ' ';
			$lineOutput .= "\t";


			if (array_key_exists($i, $this->originalExceptions))
			{
				$start = $this->originalExceptions[$i]['start'];
				$end = $this->originalExceptions[$i]['end'];

				$lineOutput .= $start;
				$lineOutput .= ' ';
				$lineOutput .= $end;
			}
			else
			{
				$lineOutput .= $this->titleOriginalTitleStart;
				$lineOutput .= $iFormatted;
				$lineOutput .= ' ';
				$lineOutput .= $this->titleOriginalTitleEnd;
				$lineOutput .= $iFormatted;
			}


			$lineOutput .= "\t";
			$lineOutput .= $this->titleAdult;
			$lineOutput .= "\t";
			$lineOutput .= $this->titleStartYear;
			$lineOutput .= "\t";
			$lineOutput .= $this->titleEndYear;
			$lineOutput .= "\t";
			$lineOutput .= $this->titleRunTimeMinutes;
			$lineOutput .= "\t";
			$lineOutput .= $this->titleGenres;
			$lineOutput .= "\n";
			$fw = fwrite($handle, $lineOutput);
			$lenLineOutput = strlen($lineOutput);
			if ($fw != $lenLineOutput)
			{
				fclose($handle);
				throw new Exception('fw='.$fw.';lenLineOutput='.$lenLineOutput);
			}
			echo "...".$i."\n";
		}
		fclose($handle);
		return TRUE;
	}
}

?>

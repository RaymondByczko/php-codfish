<?php
/**
  * @file TitleDataFileCreateAttributes.php
  * @location php-codfish/src/
  * @author Raymond Byczko
  * @history 2019-07-09;RByczko;Created this file.
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
	public $titleTconstPrefix;
	public $titleType;
	public $titlePrimaryTypeStart;
	public $titlePrimaryTypeEnd;
	public $titleOriginalTitleStart;
	public $titleOriginalTitleEnd;
	public $titleAdult;
	public $titleStartYear;
	public $titleEndYear;
	public $titleRunTimeMinutes;
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
		$this->titlePrimaryTypeStart = 'A';
		$this->titlePrimaryTypeEnd = 'E';
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
		$newObject->titlePrimaryTypeStart = 'A';
		$newObject->titlePrimaryTypeEnd = 'E';
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
			$lineOutput .= $this->titlePrimaryTypeStart;
			$lineOutput .= $iFormatted;
			$lineOutput .= ' ';
			$lineOutput .= $this->titlePrimaryTypeEnd;
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

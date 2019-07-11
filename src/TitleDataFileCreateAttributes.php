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
	public $titlePrimaryType;
	public $titleOriginalTitle;
	public $titleAdult;
	public $titleStartYear;
	public $titleEndYear;
	public $titleRunTimeMinutes;
	public $titleGenres;

	public function __construct()
	{
		$this->numLines = 1000;
		$this->fileName = 'test100.tsv';
		$this->mode = 'w+';

		$this->titleTconstPrefix = 'tt';
		$this->titleType = 'short';
		$this->titlePrimaryType = 'A';
		$this->titleOriginalTitle = 'B';
		$this->titleAdult = 0;
		$this->titleStartYear = 2019;
		$this->titleEndYear = 2019;
		$this->titleRunTimeMinutes = 60;
		$this->titleGenres = 'Documentary';


	}
	public function create()
	{
		$handle = fopen($this->fileName, $this->mode);
		if ($handle == FALSE)
		{
			return FALSE;
		}
		for ($i = 0; $i < $this->numLines; $i++)
		{
			$iStr = strval($i);
			$iStrLen = strlen($iStr);

			$iFormatted = sprintf("%0".$iStrLen."d", $i);

			$lineOutput = '';
			$lineOutput .= $this->titleTconsPrefix;
			$lineOutput .= $iFormatted;
			$lineOutput .= "\t";
			$lineOutput .= $this->titleType;
			$lineOutput .= "\t";
			$lineOutput .= $this->PrimaryType;
			$lineOutput .= $iFormatted;
			$lineOutput .= "\t";
			$lineOutput .= $this->titleOriginalTitle;
			$lineOutput .= $iFormatted;
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
			$fw = fwrite($handle, $lineOutput);
			$lenLineOutput = strlen($lineOutput);
			if ($fw != $lenLineOutput)
			{
				fclose($handle);
				throw new Exception('fw='.$fw.';lenLineOutput='.$lenLineOutput);
			}
		}
		fclose($handle);
		return TRUE;
	}
}

?>

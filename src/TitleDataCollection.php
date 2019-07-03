<?php
/**
  * @file TitleDataCollection.php
  * @location php-codfish/src
  * @company self
  * @author Raymond Byczko
  * @start_date
  * @history 2019-07-03; RByczko; Added getTdc, getSorted, findRange.
  */
namespace RaymondByczko\PhpCodfish;
use RaymondByczko\PhpCodfish\TitleData;

class TitleDataCollection
{
	private $tdc;
	private $tdcSorted;

	public function __construct()
	{
		$this->tdc = array();
		$this->tdcSorted = FALSE;
	}

	public function &getTdc()
	{
		return $this->tdc;
	}

	public function getSorted()
	{
		return $this->tdcSorted;
	}

	public function add(TitleData &$newTitleData)
	{
		$this->tdc[] = $newTitleData;
		$this->tdcSorted = FALSE;
	}

	public function sort()
	{
		usort($this->tdc, array("RaymondByczko\PhpCodfish\TitleData", "compareFirst"));
		// uasort($lCollectionTitleData, array("RaymondByczko\PhpCodfish\TitleData", "compareLast"));
		$this->tdcSorted = TRUE;
	}

	public function link()
	{
		if ($this->tdcSorted)
		{
			$firstIndex = -1; // @todo - this should be a null or not valid value.
			foreach ($this->tdc as $key=>$objTitleData)
			{
				$found = $this->quickFind($this->tdc, 'pieceFirst', $objTitleData->pieceLast, $firstIndex); 
				if ($found)
				{
					$this->findRange($firstIndex, $minIndex, $maxIndex);
				}
			}
			
		}
	
	}

	/**
	  * The following method implmentation was borrowed from the following url:
	  * https://stackoverflow.com/questions/7106772/efficient-way-to-search-object-in-an-array-by-a-property
	  *
	  */
	public function quickFind(&$array, $property, $value_to_find, &$first_index)
	{
		$l = 0;
		$r = count($array) - 1;
		$m = 0;
		while ($l <= $r) {
			$m = floor(($l + $r) / 2);
			if ($array[$m]->{$property} < $value_to_find) {
				$l = $m + 1;
			} else if ($array[$m]->{$property} > $value_to_find) {
				$r = $m - 1;
			} else {
				$first_index = $m;
				return $array[$m];
			}
		}
		return FALSE;
	}

	/**
	  * Given a startIndex of where to look in sorted array, this
	  * method will look in adjoining elements whose property value matches
	  * that located at index $startIndex.
	  *
	  * A range is then returned via specification of minIndex and maxIndex.
	  */
	public function findRange($startIndex, $property, &$minIndex, &$maxIndex)
	{
		if (!$this->sorted)
		{
			return FALSE;
		}
		$valueStart = $this->tdc[$startIndex]->{$property};
		$i = $startIndex;
		$i--;
		$tmpMinIndex = $startIndex;
		$tmpMaxIndex = $startIndex;
		while ($i >= 0)
		{
			if ($this->tdc[$i]->{$property} == $valueStart )
			{
				$tmpMinIndex = $i;
				$i--;
			}
			else
			{
				break;
			}
		}

		$j = $startIndex;
		$sizeTdc = count ($this->tdc);
		$j++;
		while ($j < $sizeTdc)
		{
			if ($this->tdc[$i]->{$property} == $valueStart )
			{
				$tmpMaxIndex = $j;
				$j++;
			}
			else
			{
				break;
			}
		
		}
		$minIndex = $tmpMinIndex;
		$maxIndex = $tmpMaxIndex;
		return TRUE;
	}

}

?>

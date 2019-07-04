<?php
/**
  * @file TitleDataCollection.php
  * @location php-codfish/src
  * @company self
  * @author Raymond Byczko
  * @start_date
  * @history 2019-07-03; RByczko; Added getTdc, getSorted, findRange.
  * @history 2019-07-03; RByczko; Adjusted quickFind, findRange methods.
  * @history 2019-07-04; RByczko; Implemented link method.  Changed signature
  * of add method from reference to non-reference. Fixed counter var.
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

	public function add(TitleData $newTitleData)
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
				// Search for pieceLast component in pieceFirst property.
				$found = $this->quickFind('pieceFirst', $objTitleData->pieceLast, $firstIndex); 
				if ($found)
				{
					$minIndex = -1;
					$maxIndex = -1;
					$property = 'pieceFirst';
					$rangeFound = $this->findRange($firstIndex, $property, $minIndex, $maxIndex);
					if (!$rangeFound)
					{
						throw new Exception('findRange returned FALSE');
					}
					// Take care of the forward links.
					for ($i = $minIndex; $i <= $maxIndex; $i++)
					{
						$objTitleData->next[] = &$this->tdc[$i];
					}
					// Take care of the back links.
					for ($j = $minIndex; $i <= $maxIndex; $i++)
					{
						$this->tdc[$j]->prev[] = &$objTitleData;
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	
	}

	/**
	  * The following method implmentation was borrowed from the following url:
	  * https://stackoverflow.com/questions/7106772/efficient-way-to-search-object-in-an-array-by-a-property
	  *
	  */
	public function quickFind($property, $value_to_find, &$first_index)
	{
		if (!$this->tdcSorted)
		{
			throw new \Exception('array not sorted');
		}
		$l = 0;
		$r = count($this->tdc) - 1;
		$m = 0;
		while ($l <= $r) {
			$m = floor(($l + $r) / 2);
			if ($this->tdc[$m]->{$property} < $value_to_find) {
				$l = $m + 1;
			} else if ($this->tdc[$m]->{$property} > $value_to_find) {
				$r = $m - 1;
			} else {
				$first_index = $m;
				// return $this->tdc[$m];
				return TRUE;
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
		if (!$this->tdcSorted)
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
			if ($this->tdc[$j]->{$property} == $valueStart )
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

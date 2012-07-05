<?php

namespace HSE\Labor\ViewHelpers;

use \TYPO3\FLOW3\Annotations as FLOW3;

/**
 * ListViewHelper
 *
 * @FLOW3\Scope("prototype")
 */
class ListViewHelper extends \TYPO3\Fluid\ViewHelpers\ForViewHelper {

	/**
	 * Initialize arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('listType', 'string', 'The list tag', TRUE);
		$this->registerArgument('additionalAttributes', 'array', 'Additional tag attributes. They will be added directly to the resulting list tag.', FALSE);
	}

	/**
	 * ViewHelper that generates a list only if needed
	 *
	 * @param array $each The array or \SplObjectStorage to iterated over
	 * @param string $as The name of the iteration variable
	 * @param string $key The name of the variable to store the current array key
	 * @param boolean $reverse If enabled, the iterator will start with the last element and proceed reversely
	 * @param string $iteration The name of the variable to store iteration information (index, cycle, isFirst, isLast, isEven, isOdd)
	 * @return string Rendered string
	 */
	public function render($each, $as, $key = '', $reverse = FALSE, $iteration = NULL) {
		if ($this->hasArgument('listType') && strlen($this->arguments['listType']) > 0) {
			$listType = $this->arguments['listType'];
		}
		if ($this->hasArgument('additionalAttributes') && is_array($this->arguments['additionalAttributes'])) {
			$additionalAttributes = $this->arguments['additionalAttributes'];
		}
		$out = '';
		if(!empty($each)) {
			$out .= '<'.$listType;
			foreach($additionalAttributes as $attribute => $value) {
				$out .= ' '.$attribute.'="'.$value.'"';
			}
			$out .= '>';
			$out .= parent::render($each, $as, $key, $reverse, $iteration);
			$out .= '</'.$listType.'>';
		}
		return $out;
	}
}

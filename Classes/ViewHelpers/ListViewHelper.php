<?php

namespace HSE\Labor\ViewHelpers;

use \TYPO3\FLOW3\Annotations as FLOW3;

/**
 * ListViewHelper
 *
 * @FLOW3\Scope("prototype")
 */
class ListViewHelper extends \TYPO3\Fluid\ViewHelpers\ForViewHelper implements \TYPO3\Fluid\Core\ViewHelper\Facets\CompilableInterface {

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
		return self::renderStatic($this->arguments, $this->buildRenderChildrenClosure(), $this->renderingContext);
	}

	/**
	 * @param array $arguments
	 * @param \Closure $renderChildrenClosure
	 * @param \TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
	 * @return string
	 * @throws \TYPO3\Fluid\Core\ViewHelper\Exception
	 */
	static public function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3\Fluid\Core\Rendering\RenderingContextInterface $renderingContext) {
		$listType = NULL;
		$additionalAttributes = array();
		if ($arguments['listType'] && strlen($arguments['listType']) > 0) {
			$listType = $arguments['listType'];
		}
		if ($arguments['additionalAttributes'] && is_array($arguments['additionalAttributes'])) {
			$additionalAttributes = $arguments['additionalAttributes'];
		}

		$out = '';
		if(count($arguments['each']) > 0) {
			$out .= '<'.$listType;
			foreach($additionalAttributes as $attribute => $value) {
				$out .= ' '.$attribute.'="'.$value.'"';
			}
			$out .= '>';
			$out .= parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
			$out .= '</'.$listType.'>';
		}
		return $out;
	}
}

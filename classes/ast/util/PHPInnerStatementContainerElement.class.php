<?php
/**
 * 
 * @author keiji
 * @package aowp.parser.ast.util
 */
/**
 * 
 * @author keiji
 * @package aowp.parser.ast.util
 */
class AOWP_PHPInnerStatementContainerElement extends AOWP_PHPElement implements AOWP_IPHPContainerElement {

	public $innerStatements;
	
	public function setElement(AOWP_PHPElement $element, $index = null) {
		$element->setParent($this);
		if ($index === null) {
			$this->innerStatements[] = $element;
		}
		else {
			$this->innerStatements[$index] = $element;
		}
	}
	public function setElements(array $elements) {
		$this->removeAllElements();
		foreach ($elements as $element) {
			if ($element instanceof AOWP_PHPElement) {
				$element->setParent($this);
			}
		}
		$this->innerStatements = $elements;
	}
	public function replaceElement(AOWP_PHPElement $element, AOWP_PHPElement $replacedElement) {
		$index = $this->searchElementInd($replacedElement);
		$replacedElement->setParent(null);
		$this->setElement($element, $index);
	}
	public function replaceElementWithElements(array $elements, AOWP_PHPElement &$replacedElements) {
		$replacedElementIndex = $this->searchElementIndex($replacedElements);
		$removedElements = $this->spliceStatement($this->innerStatements, $replacedElementIndex, 1, $elements);
		foreach ($removedElements as $removedElement) {
			$removedElement->releaseInstance();
		}
	}
	public function removeElement(AOWP_PHPElement $removedElement) {
		$index = $this->searchElementIndex($removedElement);
		$removedElement->setParent(null);
		array_splice($this->innerStatements, $index, 1);
	}
	public function removeAllElements() {
		foreach ($this->innerStatements as $innerStatement) {
			$innerStatement->setParent(null);
		}
		$this->innerStatements = array();
	}
	public function searchElementIndex(AOWP_PHPElement $element) {
		return AOWP_PHPASTCommon::searchElementIndex($this->innerStatements, $element);
	}
	public function insertElement(AOWP_PHPElement $element, $indexOrElement) {
		$indexOrElement = is_numeric($indexOrElement) ? $indexOrElement :
			$this->searchElementIndex($indexOrElement);
		$element->setParent($this);
		array_splice($this->innerStatements, $indexOrElement, 0, array($element));
	}
	public function insertElementArray(array $elementArray, $indexOrElement = null) {
		if (is_numeric($indexOrElement)) {
			
		}
		else if ($indexOrElement instanceof AOWP_PHPElement) {
			$indexOrElement = $this->searchElementIndex($indexOrElement);
		}
		else {
			$indexOrElement = count($this->innerStatements);
		}
		foreach ($elementArray as $element) {
			$element->setParent($this);
		}
		array_splice($this->innerStatements, $indexOrElement, 0, $elementArray);
	}
	public function spliceStatement(array $addedStatements, $index, $numberOfRemovedElements) {
		foreach ($addedStatements as &$addedStatement) {
			$addedStatement->setParent($this);
		}
		$removedStatements = array_splice($this->innerStatements, $index, $numberOfRemovedElements, $addedStatements);
		foreach ($removedStatements as &$removedStatement) {
			$removedStatement->releaseInstance();
		}
		return $removedStatements;
	}
	
	public function getInnerStatements() {
		return $this->innerStatements;
	}
	
}
?>
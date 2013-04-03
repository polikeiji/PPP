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
class AOWP_PHPStatementContainerElement extends AOWP_PHPElement implements AOWP_IPHPContainerElement {

	public $statements;
		
	public function setElement(AOWP_PHPElement $element, $index = null) {
		$element->setParent($this);
		if ($index === null) {
			$this->statements[] = $element;
		}
		else {
			$this->statements[$index] = $element;
		}
	}
	public function replaceElement(AOWP_PHPElement $element, AOWP_PHPElement $replacedElement) {
		$index = $this->searchElementInd($replacedElement);
		$replacedElement->setParent(null);
		$this->setElement($element, $index);
	}
	public function removeElement(AOWP_PHPElement $removedElement) {
		$index = $this->searchElementIndex($removedElement);
		$removedElement->setParent(null);
		array_splice($this->statements, $index, 1);
	}
	public function searchElementIndex(AOWP_PHPElement $element) {
		return AOWP_PHPASTCommon::searchElementIndex($this->statements, $element);
	}
	public function insertElement(AOWP_PHPElement $element, $indexOrElement) {
		$indexOrElement = is_numeric($indexOrElement) ? $indexOrElement :
			$this->searchElementIndex($indexOrElement);
		$element->setParent($this);
		array_splice($this->statements, $indexOrElement, 0, array($element));
	}
	public function insertElementArray(array $elementArray, $indexOrElement) {
//		foreach ($this->statements as $statement) {
//			AOWP_Logger::logging('[Statement] ' . get_class($statement));
//		}
		$indexOrElement = is_numeric($indexOrElement) ? $indexOrElement :
			$this->searchElementIndex($indexOrElement);
		foreach ($elementArray as $element) {
			$element->setParent($this);
		}
		array_splice($this->statements, $indexOrElement, 0, $elementArray);
//		foreach ($this->statements as $statement) {
//			AOWP_Logger::logging('[After statement] ' . get_class($statement));
//		}
	}
		
}
?>
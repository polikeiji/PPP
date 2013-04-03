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
interface AOWP_IPHPContainerElement {
	public function setElement(AOWP_PHPElement $element, $index = null);
	public function replaceElement(AOWP_PHPElement $element, AOWP_PHPElement $replacedElement);
	public function removeElement(AOWP_PHPElement $removedElement);
	public function searchElementIndex(AOWP_PHPElement $element);
}
?>
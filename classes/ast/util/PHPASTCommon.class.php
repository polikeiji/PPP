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
class AOWP_PHPASTCommon {
	
	public static function searchElementIndex(array $elementArray, AOWP_PHPElement $element) {
		for ($i = 0; $i < count($elementArray); $i++) {
			if ($elementArray[$i] === $element) {
				return $i;
			}
		}
		return null;
	}
}
?>
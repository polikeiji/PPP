<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPInnerStatementElement
 *
 * PHPのASTにおける「InnerStatement」を表すクラス。
 * 文法規則: unticked_statement。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPInnerStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	
	public function __construct($_line = null, $innerStatements = null) {
		if ($_line !== null && $innerStatements !== null) {
			$this->innerStatements = $innerStatements;
			$this->initialize($_line);
		}
		else if (is_array($_line)) {
			foreach ($_line as $element) {
				$element->setParent($this);
			}
			$this->innerStatements = $_line;
		}
		else {
			$this->innerStatements = array();
			$this->initialize($_line);
		}
	}

	public function __toString() {
		return "";
	}
	
	public function kind() {
		return "inner_statement";
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPNewElseStatementElement
 *
 * PHPのASTにおける「else:」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPNewElseStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	
	public function __construct($_line, $innerStatements) {
		$this->innerStatements 	= $innerStatements;
		$this->initialize($_line);
	}

	public function __toString() {
		return "";
	}
		
	public function kind() {
		return 'new_else';
	}
}
?>
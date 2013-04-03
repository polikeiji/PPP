<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPRootElement
 *
 * PHPのASTにおける「トップレベルの要素」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPRootElement extends AOWP_PHPStatementContainerElement {	
	
	public function __construct($_line, $statements) {
		$this->statements		= $statements;
		$this->initialize($_line);
	}
	
	public function __toString() {
		return "";
	}
	
	public function kind() {
		return 'root';
	}
}
?>
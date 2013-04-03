<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPのASTにおける「<?php ?>」を表すクラス。
 * 文法規則: unticked_statement。
 * パースの際には、使われてないような気もする 
 * (AOWP_Tokenのメタフィールドを使って、PHPタグを表現?)。。。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPTagElement extends AOWP_PHPStatementContainerElement {
	
	public function __construct($_line, $statements) {
		$this->statements = $statements;
		$this->initialize($_line);
	}
	
	public function __toString() {
		return "";
	}
	
	public function kind() {
		return 'tag';
	}
}
?>
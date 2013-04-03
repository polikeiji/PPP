<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPWhileStatementElement
 *
 * PHPのASTにおける「while」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPWhileStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	public $condition;
	
	public function __construct($_line, $condition, $innerStatements) {
		$this->condition 		= $condition;
		$this->innerStatements 	= $innerStatements;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}
	
	public function kind()
	{
		return 'while';
	}
}
?>
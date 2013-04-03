<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPNewIfStatementElement
 *
 * PHPのASTにおける「if():」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPNewIfStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	public $condition;
	//nullのときはif():のみ
	public $elseifStatements;
	//nullのときはif():のみ
	public $elseStatement;
	
	public function __construct($_line, $condition, $innerStatements, $elseifStatements, $elseStatement) {
		$this->condition 		= $condition;
		$this->innerStatements 	= $innerStatements;
		$this->elseifStatements = $elseifStatements;
		$this->elseStatement 	= $elseStatement;
		$this->initialize($_line);
	}

	public function __toString()
	{
		return "";
	}
	
	public function kind()
	{
		return 'new_if';
	}
}
?>
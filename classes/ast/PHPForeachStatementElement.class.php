<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPForeachStatementElement
 *
 * PHPのASTにおける「foreach」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPForeachStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	public $expr;
	public $foreachVariable;
	public $optionalArg;
	
	public function __construct($_line, $expr, $foreachVariable, $optionalArg, $innerStatements) {
		$this->expr				= $expr;
		$this->foreachVariable	= $foreachVariable;
		$this->optionalArg		= $optionalArg;
		$this->innerStatements	= $innerStatements;
		$this->initialize($_line);
	}

	public function __toString()
	{
		return "";
	}
	
	public function kind()
	{
		return 'foreach';
	}
}
?>
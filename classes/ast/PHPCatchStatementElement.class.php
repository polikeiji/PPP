<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPCatchStatementElement
 *
 * PHPのASTにおける「catch」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPCatchStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	public $className;
	public $variable;
	
	public function __construct($_line, $className, $variable, $innerStatements) {
		$this->className		= $className;
		$this->variable			= $variable;
		$this->innerStatements	= $innerStatements;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}
	
	public function kind()
	{
		return 'catch';
	}
}
?>
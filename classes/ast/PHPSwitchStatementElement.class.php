<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPSwitchStatementElement
 *
 * PHPのASTにおける「switch」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPSwitchStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public $expr;
	public $caseStatements;
	
	public function __construct($_line = null, $expr = null, $caseStatements = array())
	{
		$this->expr				= $expr;
		$this->caseStatements	= $caseStatements;
		$this->initialize($_line);
	}

	public function __toString()
	{
		return "";
	}
	
	public function addCaseStatement(AOWP_PHPCaseStatementElement $caseElement) {
		$caseElement->setParent($this);
		$this->caseStatements[] = $caseElement;
	}
	
	public function setVariableExpression($variableName) {
		$variableElement = new AOWP_PHPVariableElement($variableName);
		$variableElement->setParent($this);
		$this->expr = $variableElement;
	}
	
	public function kind()
	{
		return 'switch';
	}
}
?>
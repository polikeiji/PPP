<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPCaseStatementElement
 *
 * PHPのASTにおける「case」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPCaseStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	public $expr;
	
	public function __construct($_line = null, $expr = null, $innerStatements = array()) {
		$this->expr	= $expr;
		$this->innerStatements	= $innerStatements;
		$this->initialize($_line);
	}
	
	public function setScalarExpression($scalarString) {
		$scalarExpressionElement = new AOWP_PHPScalarExprElement($scalarString);
		$scalarExpressionElement->setParent($this);
		$this->expr = $scalarExpressionElement;
	}
			
	public function __toString() {
		return "";
	}
	
	public function kind() {
		return 'case';
	}
}
?>
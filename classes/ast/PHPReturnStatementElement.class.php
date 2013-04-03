<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPReturnStatementElement
 *
 * PHPのASTにおける「return」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPReturnStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	/**
	 * <code>
	 * return $var;
	 * </code>
	 * のときは、{@link AOWP_PHPVariableElement}。
	 * <code>
	 * return $obj->method();
	 * </code>
	 * のときは、{@link AOWP_PHPObjectOperatorElement}。
	 * 
	 * @var AOWP_PHPElement
	 */
	public	$expr;

	public function __construct($_line = null, $expr = null) {
		$this->expr = $expr;
 		$this->initialize($_line);
	}
	
	/**
	 * 
	 * @param string $variableName
	 * @return unknown_type
	 */
	public function setVariableExpr($variableName) {
		$this->expr = new AOWP_PHPVariableElement($variableName);
		$this->expr->setParent($this);	
	}
		
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return 'return';
	}
}
?>
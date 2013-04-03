<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPTryCatchStatementElement
 *
 * PHPのASTにおける「try-catch」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPTryCatchStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {	
	public $catchStatements;
	
	public function __construct($_line = null, $innerStatements = array(), $catchStatements = array()) {
		$this->innerStatements	= $innerStatements;
		$this->catchStatements	= $catchStatements;
		$this->initialize($_line);
	}

	public function __toString() {
		return "try";
	}
	
	public function addCatchStatement($exceptionClassName, $exceptionVariableName, array $catchStatements) {
		$this->catchStatements[] = new AOWP_PHPCatchStatementElement(null, new AOWP_Token($exceptionClassName), new AOWP_PHPVariableElement($exceptionVariableName), $catchStatements);
	}
	
	public function kind() {
		return 'try';
	}
}
?>
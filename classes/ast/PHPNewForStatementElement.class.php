<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPNewForStatementElement
 *
 * PHPのASTにおける「for(;;):」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPNewForStatementElement extends AOWP_PHPInnerStatementContainerElement implements AOWP_ITagStatementElement {
	public $initialExprs;
	public $conditions;
	public $updateExprs;
	
	public function __construct($_line, $initialExprs, $conditions, $updateExprs, $innerStatements) {
		$this->initialExprs		= $initialExprs;
		$this->conditions 		= $conditions;
		$this->updateExprs		= $updateExprs;
		$this->innerStatements 	= $innerStatements;
		$this->initialize($_line);
	}

	public function __toString()
	{
		return "";
	}
	
	public function kind()
	{
		return 'new_for';
	}
}
?>
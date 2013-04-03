<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPQuestionExprElement
 *
 * PHPのASTにおける「?」を表すクラス
 * 文法規則: unticked_statement
 * 例：		$a ? 2 : 1;
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPQuestionExprElement extends AOWP_PHPElement
{
	public $conditionExpr;
	public $trueExpr;
	public $falseExpr;

	public function __construct($_line, $conditionExpr, $trueExpr, $falseExpr)
	{
		$this->conditionExpr = $conditionExpr;
		$this->leftExpr		 = $trueExpr;
		$this->rightExpr	 = $falseExpr;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return "?";
	}
}
?>
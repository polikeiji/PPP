<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPAmpersandExprExprElement
 *
 * PHPのASTにおける「&」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPAmpersandExprElement extends AOWP_PHPElement
{
	public $expr;

	public function __construct($_line, $expr = null)
	{
		if ($expr === null && $_line instanceof AOWP_PHPElement) {
			$this->expr			 = $_line;
		}
		else {
			$this->expr			 = $expr;
			$this->initialize($_line);
		}
	}
	
	public function __toString()
	{
		return "";
	}
	
	public function getVariableName() {
		return $this->expr->getVariableName();
	}
	
	public function kind()
	{
		return '&';
	}
}
?>
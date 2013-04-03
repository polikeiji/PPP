<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPBracketExprElement
 *
 * PHPのASTにおける「(expr)」を表すクラス
 * 文法規則: unticked_statement
 * 例：		($a + 2);
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPBracketExprElement extends AOWP_PHPElement
{
	public $expr;

	public function __construct($_line, $expr)
	{
		$this->expr = $expr;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	

	public function kind()
	{
		return "bracket";
	}
}
?>
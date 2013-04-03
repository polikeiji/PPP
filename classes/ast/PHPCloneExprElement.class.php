<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPCloneExprElement
 *
 * PHPのASTにおける「clone」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPCloneExprElement extends AOWP_PHPElement
{
	public $expr;
	
	public function __construct($_line, $expr)
	{
		$this->expr			 = $expr;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return "clone";
	}
}
?>
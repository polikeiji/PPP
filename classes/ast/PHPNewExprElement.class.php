<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPNewExprElement
 *
 * PHPのASTにおける「new」を表すクラス
 * 文法規則: expr_without_variable
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPNewExprElement extends AOWP_PHPElement
{	
	public $className;
	public $arguments;
	
	public function __construct($_line, $className, $arguments)
	{
		$this->className		= $className;
		$this->arguments		= $arguments;
		$this->initialize($_line);
	}
	
	public function kind()
	{
		return "new";
	}
	
	public function __toString()
	{
		return "";
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPIndirectVariableElement
 *
 * PHPのASTにおける「変数」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPIndirectVariableElement extends AOWP_PHPElement
{
	public $dollars;
	public $variable;

	public function __construct($_line, $dollars, $variable)
	{
		$this->dollars		 = $dollars;
		$this->variable		 = $variable;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'indirect_variable';
	}
}
?>
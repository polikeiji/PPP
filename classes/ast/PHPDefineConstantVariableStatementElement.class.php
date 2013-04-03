<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPDefineVariableStatementElement
 *
 * PHPのASTにおける「変数定義」を表すクラス
 * 文法規則: unticked_statement
 * 例：		;
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPDefineConstantVariableStatementElement extends AOWP_PHPElement
{
	public $constantVariables;
	
	public function __construct($_line, $constantVariables)
	{
		$this->constantVariables = $constantVariables;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}
	
	public function kind()
	{
		return "define_constant_variable_statement";
	}	
}

?>
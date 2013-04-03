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
class AOWP_PHPDefineConstantVariableElement extends AOWP_PHPElement
{
	public $variableName;
	public $initialValue;

	public function __construct($_line, $variableName, $initialValue)
	{
		$this->variableName	 = $variableName;
		$this->initialValue	 = $initialValue;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return "define_constant_variable";
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPClassConstVariableElement
 *
 * PHPのASTにおける「::」を表すクラス
 * 文法規則: function_call_parameter_list
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPClassConstVariableRefElement extends AOWP_PHPElement
{
	public $className;
	public $variableName;

	public function __construct($_line, $className, $variableName)
	{
		$this->className	 = $className;
		$this->variableName	 = $variableName;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
		
	public function kind()
	{
		return "::";
	}
}
?>
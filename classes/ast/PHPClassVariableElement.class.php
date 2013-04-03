<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPClassVariableElement
 *
 * PHPのASTにおける「クラス変数」を表すクラス
 * 文法規則: class_variable_declaration
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPClassVariableElement extends AOWP_PHPElement
{
	public $modifiers;
	public $variables;
	
	public function __construct($_line, $modifiers, $variables)
	{
		$this->modifiers	= $modifiers;
		$this->variables	= $variables;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'class_variable';
	}
}
?>
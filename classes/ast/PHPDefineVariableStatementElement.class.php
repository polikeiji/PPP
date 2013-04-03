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
class AOWP_PHPDefineVariableStatementElement extends AOWP_PHPElement
{
	public $type;
	public $variables;

	public function __construct($_line, $type, $variables)
	{
		$this->type			 = $type;
		$this->variables	 = $variables;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'define_' . $this->type . '_variable';
	}
}
?>
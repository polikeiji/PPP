<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPComplexVariableElement
 *
 * PHPのASTにおける「変数」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPComplexVariableElement extends AOWP_PHPElement
{
	public $openCurly;
	public $expr;

	public function __construct($_line, $openCurly, $expr)
	{
		$this->openCurly	 = $openCurly;
		$this->expr			 = $expr;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'complex_variable';
	}
}
?>
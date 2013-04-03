<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPPostfixMonadicOperatprExprElement
 *
 * PHPのASTにおける「単項演算子式（左に演算子）」を表すクラス
 * 文法規則: unticked_statement
 * 例：		$a++;
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPPostfixMonadicOperatorExprElement extends AOWP_PHPElement
{
	public $variable;
	public $operatorName;

	public function __construct($_line, $variable, $operatorName)
	{
		$this->variable		 = $variable;
		$this->operatorName	 = $operatorName;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return $this->operatorName;
	}
}
?>
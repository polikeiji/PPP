<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPPrefixMonadicOperatprExprElement
 *
 * PHPのASTにおける「単項演算子式（右に演算子）」を表すクラス
 * 文法規則: unticked_statement
 * 例：		++$a;
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPPrefixMonadicOperatorExprElement extends AOWP_PHPElement
{
	public $operatorName;
	public $variable;
	private $_line;

	public function __construct($_line = null, $operatorName = null, $variable = null)
	{
		$this->operatorName	 = $operatorName;
		$this->variable		 = $variable;
		$this->_line		 = $_line;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function line()
	{
		return $this->_line;
	}
	
	public function kind()
	{
		return $this->operatorName;
	}
}
?>
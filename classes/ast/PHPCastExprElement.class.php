<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPCastExprElement
 *
 * PHPのASTにおける「cast式」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPCastExprElement extends AOWP_PHPElement
{
	public $typeName;
	public $expr;

	public function __construct($_line, $typeName, $expr)
	{
		$this->typeName		 = $typeName;
		$this->expr			 = $expr;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'cast_' . $this->typeName;
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPInstanceofExprElement
 *
 * PHPのASTにおける「instanceof」を表すクラス
 * 文法規則: unticked_statement
 * 例：		
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPInstanceofExprElement extends AOWP_PHPElement
{
	public $expr;
	public $className;

	public function __construct($_line, $expr, $className)
	{
		$this->expr			 = $expr;
		$this->className	 = $className;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return "instanceof";
	}
}
?>
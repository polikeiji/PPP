<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPInnerStatementElement
 *
 * PHPのASTにおける「list()」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPListElement extends AOWP_PHPElement
{
	public $assignments;
	
	public function __construct($_line, $assignments)
	{
		$this->assignments 	= $assignments;
		$this->initialize($_line);
	}

	public function __toString()
	{
		return "";
	}

	public function kind()
	{
		return "list";
	}
}
?>
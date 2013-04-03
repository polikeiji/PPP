<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPEnpryStatementElement
 *
 * PHPのASTにおける「enpty」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPEmptyStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public $variable;

	public function __construct($_line, $variable)
	{
		$this->variable		 = $variable;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'empty';
	}
}
?>
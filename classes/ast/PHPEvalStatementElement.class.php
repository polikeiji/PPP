<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPEvalStatementElement
 *
 * PHPのASTにおける「eval」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPEvalStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public $expr;

	public function __construct($_line, $expr)
	{
		$this->expr			 = $expr;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'eval';
	}
}
?>
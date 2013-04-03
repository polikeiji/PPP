<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPEchoStatementElement
 *
 * PHPのASTにおける「echo」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPEchoStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public $exprs;

	public function __construct($_line = null, $exprs = null)
	{
		$this->exprs		 = $exprs;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'echo';
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPBreakStatementElement
 *
 * PHPのASTにおける「break」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPBreakStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public 	$expr;

	public function __construct($_line = null, $expr = null) {
		if ($_line !== null && $expr !== null) {
			$this->expr			 = $expr;
			$this->initialize($_line);
		}
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'break';
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPUseStatementElement
 *
 * PHPのASTにおける「use」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPUseStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public $filename;

	public function __construct($_line, $filename)
	{
		$this->filename		 = $filename;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'use';
	}
}
?>
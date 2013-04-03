<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPUnsetStatementElement
 *
 * PHPのASTにおける「unset」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPUnsetStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public $variables;

	public function __construct($_line, $variables)
	{
		$this->variables	 = $variables;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'unset';
	}
}
?>
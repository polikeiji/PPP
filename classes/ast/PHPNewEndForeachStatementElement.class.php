<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPNewEndForeachStatementElement
 *
 * PHPのASTにおける「endforeach:」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPNewEndForeachStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {	
	public function __construct($_line)
	{
		$this->initialize($_line);
	}

	public function __toString()
	{
		return "";
	}
		
	public function kind()
	{
		return 'endforeach';
	}
}
?>
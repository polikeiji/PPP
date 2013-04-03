<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPBackquoteExprElement
 *
 * PHPのASTにおける「<<<」を表すクラス
 * 文法規則: unticked_statement
 * 例：		
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPHeredocExprElement extends AOWP_PHPElement
{
	//backquote or doublequote or singlequote or heardoc
	public $docName;
	public $encaps;
	
	public function __construct($_line, $encaps, $docName)
	{
		$this->docName		 = $docName;
		$this->encaps		 = $encaps;
		$this->initialize($_line);
	}
	
	
	public function __toString()
	{
		return "";
	}	
	
	
	
	public function kind()
	{
		return "heredoc";
	}
}
?>
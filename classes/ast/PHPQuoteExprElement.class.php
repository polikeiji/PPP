<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPBackquoteExprElement
 *
 * PHPのASTにおける「`command`」を表すクラス
 * 文法規則: unticked_statement
 * 例：		`ls`;
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPQuoteExprElement extends AOWP_PHPElement
{
	//backquote or doublequote or singlequote
	public $type;
	public $encaps;
	
	public function __construct($_line, $type, $encaps)
	{
		$this->type			 = $type;
		$this->encaps		 = $encaps;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return $this->type;
	}
}
?>
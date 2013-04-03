<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPInnerHTMLStatementElement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPInnerHTMLStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	public $value;

	public function __construct($_line, $value = null) {
		if ($value !== null) {
			$this->value		 = $value;
			$this->initialize($_line);
		}
		else {
			$this->value = $_line;
		}
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return "html";
	}
	
	public static function createPHPOpenTag() {
		return new AOWP_PHPInnerHTMLStatementElement(new AOWP_Token(null, null, null, array(null, '<?php')));
	}
	public static function createPHPCloseTag() {
		return new AOWP_PHPInnerHTMLStatementElement(new AOWP_Token(null, null, null, array(null, '?>')));
	}
}
?>
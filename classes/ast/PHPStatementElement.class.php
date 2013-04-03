<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPの一文を表すクラス。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	/**
	 * 
	 * @var AOWP_PHPElement
	 */
	public $expr;
	
	public function __construct($_lineOrExpr, $expr = null) {
		if ($expr !== null) {
			$this->expr = $expr;
		}
		else {
			$this->expr = $_lineOrExpr;
		}
		$this->initialize($_lineOrExpr);
	}
	
	public function __toString() {
		return "";
	}
	
	public function kind() {
		return "statement";
	}
}
?>
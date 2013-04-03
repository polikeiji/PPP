<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPのASTにおける「=>」を表すクラス。
 * 文法規則: function_call_parameter_list。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPArrayPairElement extends AOWP_PHPElement {
	/**
	 * 配列のキーを表します。
	 * キーを配列定義で使用しない場合、このフィールドは空です。
	 * 
	 * @var AOWP_PHPElement
	 */
	public $keyExpr;
	
	/**
	 * 配列の値を表します
	 * {@link AOWP_PHPVariableElement} or {@link AOWP_PHPReferenceVariableElement} or 
	 * {@link AOWP_ScalarExprElement}
	 * 
	 * @var AOWP_PHPElement
	 */
	public $valueExpr;

	public function __construct($_line, $key, $value) {
		$this->keyExpr = $key;
		$this->valueExpr = $value;
		$this->initialize($_line);
	}
	
	public function __toString() {
		return "";
	}	

	public function kind() {
		return "=>";
	}
}
?>
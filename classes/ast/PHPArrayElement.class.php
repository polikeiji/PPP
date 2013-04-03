<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPのASTにおける「array」を表すクラス。
 * 文法規則: function_call_parameter_list。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPArrayElement extends AOWP_PHPElement {
	/**
	 * {@link AOWP_PHPArrayPairElement} の配列。
	 * 
	 * @var array
	 */
	public $pairs;

	public function __construct($_line = null, $pairs = null) {
		if ($_line !== null && $pairs !== null) {
			$this->pairs = $pairs;
		}
		else {
			$this->pairs = array();
		}
		$this->initialize($_line);
	}
	
	/**
	 * 配列の要素を、追加します。
	 * このメソッドは、引き数を1つだけ指定し、要素の値のみを代入する場合と、
	 * キーと値の2つの引き数を指定する呼び出し方が有ります。
	 * 引き数の型は、{@link AOWP_PHPVariableElement} or {@link AOWP_PHPReferenceVariableElement} or 
	 * {@link AOWP_ScalarExprElement} です。
	 * 
	 * @param $keyOrValue
	 * @param $value
	 * @return void
	 */
	public function addElement(AOWP_PHPElement $keyOrValue, AOWP_PHPElement $value = null) {
		$arrayPairElement = null;
		if ($value === null) {
			$arrayPairElement = new AOWP_PHPArrayPairElement(null, null, $keyOrValue);
		}
		else {
			$arrayPairElement = new AOWP_PHPArrayPairElement(null, $keyOrValue, $value);
		}
		$arrayPairElement->setParent($this);
		$this->pairs[] = $arrayPairElement;
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return "array";
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPのASTにおける「実引数」を表すクラス
 * 文法規則: function_call_parameter_list
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 */
class AOWP_PHPArgumentElement extends AOWP_PHPElement {
	/**
	 * 引き数の式を表すASTのインスタンス。
	 * {@link AOWP_PHPScalarExprElement} or {@link AOWP_PHPVariableElement} or
	 * {@link AOWP_PHPReferenceVariableElement} (要調査)。
	 * 
	 * @var AOWP_PHPElement
	 */
	public $expr;

	public function __construct($_line = null, $expr = null) {
		if ($expr === null && $_line instanceof AOWP_PHPElement) {
			$this->expr = $_line;
		}
		else {
			$this->expr	= $expr;
			$this->initialize($_line);
		}
	}
	
	/**
	 * {@link AOWP_PHPArgumentElement::expr} の値の clone を取得します。 
	 * 
	 * @return AOWP_PHPElement
	 */
	public function getExpr() {
		return clone $this->expr;
	}
	
	/**
	 * 変数の引き数を表す、ASTインスタンスを作成する。
	 * 
	 * @param string $variableName 変数名
	 * @return AOWP_PHPArgumentElement
	 */
	public static function createVariableArgument($variableName) {
		$argumentElement = new AOWP_PHPArgumentElement();
		$argumentElement->expr = new AOWP_PHPVariableElement($variableName);
		return $argumentElement;
	}
	
	/**
	 * 配列の引き数を表す、ASTインスタンスを作成する。
	 * 
	 * @param string $variableName 変数名
	 * @param int $numberIndex 配列の添字
	 * @return AOWP_PHPArgumentElement
	 */
	public static function createArrayArgumentWithNumberIndex($variableName, $numberIndex) {
		$argumentElement = new AOWP_PHPArgumentElement();
		$referenceVariableElement = new AOWP_PHPReferenceVariableElement(new AOWP_PHPVariableElement($variableName));
		$referenceVariableElement->setIndexNumber($numberIndex);
		$argumentElement->expr = $referenceVariableElement;
		return $argumentElement;
	}
	
	/**
	 * 
	 * @param $element
	 * @return void
	 */
	public function setExpr(AOWP_PHPElement $element) {
		$this->expr = $element;
		$element->setParent($this);
	}
	
	/**
	 * 引き数に、指定した名前の変数を設定します。
	 * 
	 * @param string $variableName
	 * @return void
	 */
	public function setVariableArgumentName($variableName) {
		$this->expr = new AOWP_Token($variableName);
	}
	
	/**
	 * 文字列、もしくは数値の引き数を表す、ASTインスタンスを作成する。
	 * 
	 * @param string $stringValue 文字列
	 * @return AOWP_PHPArgumentElement
	 */
	public static function createStringArgument($stringValue) {
		$argumentElement = new AOWP_PHPArgumentElement();
		if (is_numeric($stringValue)) {
			$argumentElement->expr = new AOWP_PHPScalarExprElement($stringValue);
		}
		else {
			$argumentElement->expr = new AOWP_PHPScalarExprElement("'" . $stringValue . "'");
		}
		return $argumentElement;
	}
	
	public static function createScalarArgument($scalar) {
		$argumentElement = new AOWP_PHPArgumentElement();
		$argumentElement->expr = new AOWP_PHPScalarExprElement($scalar);
		return $argumentElement;
	}
	
	public function isArrayArgument() {
		return $this->expr instanceof AOWP_PHPReferenceVariableElement;
	}
	
	public function __toString() {
		return "";
	}	

	public function kind() {
		return "arg";
	}
}
?>
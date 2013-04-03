<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPObjectOperatorElement
 *
 * PHPのASTにおける「->」を表すクラス
 * 文法規則: expr_without_variable
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 * $hoge->a->b->c;
 */
class AOWP_PHPObjectOperatorElement extends AOWP_PHPElement {
	/**
	 * "->"の左側のトークンを表すASTインスタンス。
	 * 例えば、
	 * <code>
	 * $a->b->c();
	 * </code>
	 * の場合、$aを表すインスタンス。
	 * 型は、{@link AOWP_PHPVariableElement}。 (要調査)
	 * 
	 * @var AOWP_PHPVariableElement
	 */
	public $expr;
	
	/**
	 * "->"の右側のトークンを左から順に格納した配列。
	 * 例えば、
	 * <code>
	 * $a->b->c();
	 * </code>
	 * の場合、array(bを表すインスタンス, cを表すインスタンス)の長さ2の配列となる。
	 * 配列要素の型は、{@link AOWP_PHPObjectPropertyElement}。
	 * 
	 * @var array
	 */
	public $objectProperties;
	
	public function __construct($_line = null, $expr = null, $objectProperties = null) {
		if ($_line !== null && $expr !== null && $objectProperties !== null) {
			$this->expr				= $expr;
			$this->objectProperties = $objectProperties;
		}
		$this->initialize($_line);
	}
	
	/**
	 * 左端の変数名を取得する。
	 * 
	 * @return string
	 */
	public function getLeftVariableName() {
		return $this->expr->getVariableName();
	}
	
	public function getLeftExpr() {
		return $this->expr;
	}
	
	public function addObjectProperty(AOWP_PHPObjectPropertyElement $element) {
		$this->objectProperties[] = $element;
	}
	
	/**
	 * 引き数のAST要素が、このクラスのインスタンスの {@link AOWP_PHPObjectOperatorElement::objectProperties}の
	 * 何番目の要素かを取得します。
	 * もし、引き数のAST要素が、objectProperties に含まれない場合、nullを返します。
	 * 
	 * @param $objectPropertyElement
	 * @return mixed
	 */
	public function getObjectPropertyIndex(AOWP_PHPObjectPropertyElement &$objectPropertyElement) {
		for ($i = 0; $i < count($this->objectProperties); $i++) {
			if ($this->objectProperties[$i] === $objectPropertyElement) {
				return $i;
			}
		}
		return null;
	}
	
	/**
	 * 
	 * @return AOWP_PHPObjectPropertyElement
	 */
	public function getFirstObjectProperty() {
		return isset($this->objectProperties[0]) ? $this->objectProperties[0] : null;
	}
	
	/**
	 * 
	 * @return int
	 */
	public function getPropertyCount() {
		return count($this->objectProperties);
	}
	
	/**
	 * 
	 * @param $variableNameString
	 * @return string
	 */
	public function setLeftVariableName($variableNameString) {
		$this->expr = new AOWP_PHPVariableElement($variableNameString);
	}
	
	public function kind() {
		return "->";
	}
	
	public function __toString() {
		return "";
	}
	
}
?>
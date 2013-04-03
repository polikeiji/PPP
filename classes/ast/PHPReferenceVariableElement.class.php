<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPのASTにおける「変数」を表すクラス。
 * 文法規則: unticked_statement。
 * {@link AOWP_VariableElement}は、非配列変数で、
 * このクラスは、添字付きの配列変数を表す。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPReferenceVariableElement extends AOWP_PHPElement implements AOWP_IPHPVariable {
	/**
	 * 1次元配列の時は、{@link AOWP_PHPVariableElement}。
	 * 多次元配列の時は、{@link AOWP_PHPReferenceElement}。
	 * 
	 * @var mixed
	 */
	public $variable;
	
	/**
	 * {@link AOWP_PHPVariableElement} or {@link AOWP_PHPScalarExprElement}
	 * 
	 * @var AOWP_PHPElement $indexExpr
	 */
	public $indexExpr;

	/**
	 * $_lineOrVariableElementは、{@link AOWP_PHPVariableElement} か {@link AOWP_ReferenceVariableElement} か intです。
	 * 
	 * @param $_lineOrVariableElement
	 * @param $variable
	 * @param $indexExpr
	 * @return unknown_type
	 */
	public function __construct($line, $variable = null, $indexExpr = null) {
		$this->variable  = $variable;
		$this->indexExpr = $indexExpr;
		$this->initialize($line);
	}
	
	/**
	 * 変数名を変更します。
	 * 
	 * @param string $variableName
	 * @return void
	 */
	public function setVariableName($variableName) {
		$leftVariableElement = $this->_getLeftVariableElement();
		$leftVariableElement->setVariableName($variableName);
	}
	
	/**
	 * 数字 (定数) のインデックスを設定します。
	 * 
	 * @param int $indexNumber
	 * @return void
	 */
	public function setIndexNumber($indexNumber) {
		$this->setIndexExpr(new AOWP_PHPScalarExprElement($indexNumber));
	}
	
	/**
	 * 文字列のインデックスを設定します。
	 * 
	 * @param string $indexString
	 * @return void
	 */
	public function setIndexString($indexString) {
		$this->setIndexExpr(new AOWP_PHPScalarExprElement("'" . $indexString . "'"));
	}
	
	/**
	 * 引き数のエレメントを、この配列の添字として設定します。
	 * 
	 * @param $element
	 * @return void
	 */
	public function setIndexExpr(AOWP_PHPElement $element) {
		$this->indexExpr = $element;
		$element->setParent($this);
	}
	
	/**
	 * 引き数のASTエレメントを、この配列の添字として追加します。
	 * 返り値は、この添字を追加後の配列を表すASTインスタンスです。
	 * $doClone が true の場合、呼び出されるインスタンスは、cloneで複製されて、
	 * 新たなASTインスタンスが生成されます。
	 * 
	 * @param $element
	 * @param bool $doClone
	 * @return AOWP_PHPReferenceVariableElement
	 */
	public function addIndexExpr(AOWP_PHPElement $element, $doClone = false) {
		$newArrayVariableElement = $doClone ? 
			new AOWP_PHPReferenceVariableElement((clone $this)) :
			new AOWP_PHPReferenceVariableElement($this);
		$newArrayVariableElement->setIndexExpr($element);
		return $newArrayVariableElement;
	}
	
	/**
	 * この配列の、変数 (添字を除く) を表す {@link AOWP_PHPVariableElement} を取得します。 
	 * 
	 * @return AOWP_PHPVariableElement
	 */
	private function _getLeftVariableElement() {
		$variableOrReferenceVariableElement = $this->variable;
		while (!($variableOrReferenceVariableElement instanceof AOWP_PHPVariableElement)) {
			$variableOrReferenceVariableElement = $variableOrReferenceVariableElement->variable;
		}
		return $variableOrReferenceVariableElement;
	}
	
	/**
	 * この配列の全ての添字を表すASTインスタンスを、
	 * 配列で取得します。
	 * 例えば、
	 * <code>
	 * $a[1]['2'][$f];
	 * </code>
	 * の場合、左から 1、'2'、$fの順でASTインスタンスが配列に格納されます。
	 * 配列に入る可能性があるASTを表すクラスは、{@link AOWP_PHPVariableElement}、
	 * {@link AOWP_PHPScalarExprElement} です。
	 * 
	 * @return array
	 */
	public function getIndexArray() {
		$indexArray = array();
		$indexArray[] = &$this->indexExpr;
		$variableOrReferenceVariableElement = &$this->variable;
		while (!($variableOrReferenceVariableElement instanceof AOWP_PHPVariableElement)) {
			$indexArray = &$variableOrReferenceVariableElement->indexExpr;
			$variableOrReferenceVariableElement = &$variableOrReferenceVariableElement->variable;
		}
		return $indexArray;
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return 'reference_variable';
	}
}
?>
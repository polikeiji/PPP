<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPEqualExprElement
 *
 * PHPのASTにおける「代入式」を表すクラス。
 * 文法規則: unticked_statement。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPEqualExprElement extends AOWP_PHPElement
{
	/**
	 * 左辺の変数を表すフィールド。
	 * 型については、要調査。
	 * 
	 * @var AOWP_PHPVariableElement
	 */
	public $variable;
	
	/**
	 * 式の符号を表すフィールド。
	 * 
	 * @var string
	 */
	public $operatorName;
	
	/**
	 * 右辺を表すフィールド。
	 * <code>
	 * $v = $obj->m();
	 * </code>
	 * 等の場合、{@link AOWP_PHPObjectOperatorElement}のインスタンスが設定される。
	 * <code>
	 * $v = 'Taro';
	 * </code>
	 * 等の場合、{@link AOWP_PHPScalarExprElement}のインスタンスが設定される。
	 * <code>
	 * $v = $v2;
	 * </code>
	 * 等の場合、{@link AOWP_PHPVaribleElement}のインスタンスが設定される。
	 * 
	 * @var AOWP_PHPElement
	 */
	public $expr;

	/**
	 * 引き数が2個の場合、第１引数が 左辺の変数名を表す文字列で、
	 * 第2引数が、右辺を表す {@link AOWP_PHPObjectOperatorElement}、
	 * {@link AOWP_PHPScalarExprElement}、{@link AOWP_PHPVaribleElement}、
	 * のいずれかのASTインスタンス。
	 * 
	 * @param mixed $_lineOrVariableName string or int
	 * @param AOWP_PHPElement $variableOrExprElement
	 * @param $operatorName
	 * @param $expr
	 * @return void
	 */
	public function __construct($_lineOrVariableName, $variableOrExprElement, $operatorName = null, $expr = null) {
		if ($operatorName !== null && $expr !== null) {
			$this->variable 	 = $variableOrExprElement;
			$this->operatorName	 = $operatorName;
			$this->expr			 = $expr;
		}
		else {
			$this->variable = new AOWP_PHPVariableElement($_lineOrVariableName);
			$this->operatorName = '=';
			$this->expr = $variableOrExprElement;
		}
		$this->initialize($_lineOrVariableName);
	}
		
	public function getLeftVarialeName() {
		return isset($this->variable) && ($this->variable instanceof AOWP_PHPVariableElement) ?
			$this->variable->getVariableName() :
			null;
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return $this->operatorName;
	}
	
}
?>
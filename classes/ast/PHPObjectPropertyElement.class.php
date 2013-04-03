<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPObjectPropertyElement
 *
 * PHPのASTにおける「->」を表すクラス
 * 文法規則: expr_without_variable
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPObjectPropertyElement extends AOWP_PHPElement {	
	/**
	 * 型について要調査。
	 * 
	 * @var AOWP_Token
	 */
	public $propertyName;
	
	/**
	 * メソッドの場合、{@link AOWP_PHPArgumentElement}の配列。
	 * 変数の場合は、null。
	 * 
	 * @var array
	 */
	public $arguments;
	
	private $_line;
	
	/**
	 * 
	 * @param string $propertyName
	 * @param bool $isMethod
	 * @return void
	 */
	public function __construct($_lineOrPropertyName = null, $propertyNameOrIsMethod = null, $arguments = null) {
		$this->propertyName = $propertyNameOrIsMethod;
		$this->arguments = $arguments;
		$this->initialize($_lineOrPropertyName);
	}
	
	/**
	 * 
	 * @param string $propertyName
	 * @return void
	 */
	public function setTokenPropertyName($propertyName) {
		$this->propertyName = new AOWP_Token($propertyName);
	}
	
	/**
	 * 参照するプロパティ名 (呼び出すメソッド名) を取得します。
	 * 
	 * @return string
	 */
	public function getPropertyName() {
		return $this->propertyName->__toString();
	}
	
	/**
	 * 
	 * @param AOWP_PHPArgumentElement $argument
	 * @return void
	 */
	public function addArgument(AOWP_PHPArgumentElement $argument) {
		$this->arguments[] = $argument;
		$argument->setParent($this);
	}
	
	/**
	 * 何番目のメソッド呼び出し (もしくは、フィールドアクセス) かを取得します。
	 * 例えば、
	 * <code>
	 * $a->b->c()->d;
	 * </code>
	 * で、このインスタンスがcのメソッド呼び出しを表す場合、2を結果として取得できます。
	 * 
	 * @return int
	 */
	public function getObjectPropertyIndex() {
		return $this->getParent()->getObjectPropertyIndex($this);
	}
	
	/**
	 * メソッド呼び出しの場合、引き数の数を取得します。
	 * フィールドアクセスの場合、nullを返します。
	 *
	 * @return int
	 */
	public function getArgumentCount() {
		return $this->isMethodCall() ? count($this->arguments) : null;
	}
	
	/**
	 * 指定したインデックスの{@link AOWP_PHPArgumentElement}を、
	 * 引き数の値で置き換えます。
	 * 
	 * @param $argument
	 * @param $index
	 * @return unknown_type
	 */
	public function setArgument(AOWP_PHPArgumentElement $argument, $index) {
		$this->arguments[$index] = $argument;
		$argument->setParent($this);
	}
	
	public function kind() {
		return "property";
	}
	
	public function __toString() {
		return "";
	}
	
	public function isMethodCall() {
		return $this->arguments !== null && is_array($this->arguments);
	}
}
?>
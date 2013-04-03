<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPMethodElement
 *
 * PHPのASTにおける「メソッド」を表すクラス
 * 文法規則: class_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPMethodElement extends AOWP_PHPInnerStatementContainerElement {
	const PRIVATE_MODIFER = 'private';
	const PUBLIC_MODIFER = 'public';
	const STATIC_MODIFER = 'static';
	const FINAL_MODIFER = 'final';
	
	/**
	 * 修飾子を表す文字列の配列。
	 * 
	 * @var array
	 */
	public $modifiers;
	public $isReference;
	/**
	 * 
	 * @var AOWP_Token
	 */
	public $functionName;
	/**
	 * 
	 * @var array
	 */
	public $paramaters;
	
	public function __construct($_line = null, $modifiers = array(), $isReference = null, $functionName = null, $paramaters = array(), $innerStatements = array()) {
		$this->modifiers = $modifiers;
		$this->isReference = $isReference;
		$this->functionName = $functionName;
		$this->paramaters = $paramaters;
		$this->innerStatements = $innerStatements;
		$this->initialize($_line);
	}
	
	public function getClassName() {
		$classElement = $this->getParent();
		return $classElement->getClassName();
	}
	
	/**
	 * 
	 * @param string $methodName
	 * @return void
	 */
	public function setMethodName($methodName) {
		$this->functionName = new AOWP_Token($methodName);
	}
	/**
	 * 
	 * @return string
	 */
	public function getMethodName() {
		return $this->functionName !== null ? $this->functionName->__toString() : null;
	}
	
	public function getParameterCount() {
		return count($this->paramaters);
	}
	public function getParameterName($parameterIndex) {
		return $this->paramaters[$parameterIndex]->getParameterName();
	}
	
	/**
	 * 
	 * @param string $modifier
	 * @return void
	 */
	public function addModifier($modifier) {
		if (array_search($modifier, $this->modifiers) === false) {
			$this->modifiers[] = $modifier;
		}
	}
	/**
	 * 
	 * @param string $modifier
	 * @return void
	 */
	public function removeModifier($modifier) {
		for ($i = 0; $i < count($this->modifiers); $i++) {
			if ($this->modifiers[$i] == $modifier) {
				array_splice($this->modifiers, $i, 1);
				break;
			}
		}
	}
	/**
	 * 
	 * @param $modifierArray
	 * @return void
	 */
	public function setModifiers($modifierArray) {
		$this->modifiers = $modifierArray;
	}
	/**
	 * 
	 * @return array
	 */
	public function getModifiers() {
		return $this->modifiers;
	}
		
	/**
	 * 
	 * @return array
	 */
	public function getParameters() {
		return $this->paramaters;
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return 'method';
	}

}
?>
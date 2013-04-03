<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast.util
 */

/**
 * 連続しないメソッド呼び出しを表す、
 * {@link AOWP_PHPObjectOperatorElement}のシンプル版の便利クラス。
 * 例えば、以下の連続したメソッド呼び出しは、このクラスでは表現できない。
 * <code>
 * $a->b()->c();
 * </code>
 *
 * @package aowp.parser.ast.util
 * @access  public
 * @author keiji
 */
class AOWP_PHPSimpleMethodCallElement extends AOWP_PHPObjectOperatorElement {

	/**
	 * 
	 * @param string $objectName
	 * @param string $methodName
	 * @return void
	 */
	public function __construct($objectVariableName, $methodName) {
		$this->expr = new AOWP_PHPVariableElement($objectVariableName);
		$methodCallProperty = new AOWP_PHPObjectPropertyElement();
		$methodCallProperty->setTokenPropertyName($methodName);
		$methodCallProperty->arguments = array();
		$this->objectProperties = array($methodCallProperty);
		$this->initialize(null);
	}
	
	/**
	 * 
	 * @param $argumentElement
	 * @return void
	 */
	public function addArgument(AOWP_PHPArgumentElement $argumentElement) {
		$this->objectProperties[0]->addArgument($argumentElement);
	}
	
	public function addVariableArgument($variableName) {
		$this->addArgument(new AOWP_PHPArgumentElement(new AOWP_PHPVariableElement($variableName)));
	}
			
}
?>
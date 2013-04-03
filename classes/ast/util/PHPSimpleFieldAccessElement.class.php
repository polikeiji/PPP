<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast.util
 */

/**
 * 連続しないフィールドアクセスを表す、
 * {@link AOWP_PHPObjectOperatorElement}のシンプル版の便利クラス。
 * 例えば、以下の連続したフィールドアクセスは、このクラスでは表現できない。
 * <code>
 * $a->b->c;
 * </code>
 *
 * @package aowp.parser.ast.util
 * @access  public
 * @author keiji
 */
class AOWP_PHPSimpleFieldAccessElement extends AOWP_PHPObjectOperatorElement {

	/**
	 * 
	 * @param string $objectName
	 * @param string $fieldName
	 * @return void
	 */
	public function __construct($objectVariableName, $fieldName) {
		$this->expr = new AOWP_PHPVariableElement($objectVariableName);
		$fieldAccessProperty = new AOWP_PHPObjectPropertyElement();
		$fieldAccessProperty->setTokenPropertyName($fieldName);
		$this->objectProperties = array($fieldAccessProperty);
		$this->initialize(null);
	}
	
}
?>
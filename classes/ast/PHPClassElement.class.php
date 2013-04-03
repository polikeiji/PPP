<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPClassElement
 *
 * PHPのASTにおける「クラス」を表すクラス
 * 文法規則: unticked_class_declaration_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPClassElement extends AOWP_PHPElement
{
	public $typeName;
	public $className;
	public $extendClassName;
	public $implementInterfaceNames;
	public $classStatements;
	
	public function __construct($_line, $typeName, $className, $extendClassName, $implementInterfaceNames, $classStatements) {
		$this->typeName					= $typeName;
		$this->className 				= $className;
		$this->extendClassName 			= $extendClassName;
		$this->implementInterfaceNames 	= $implementInterfaceNames;
		$this->classStatements			= $classStatements;
		$this->initialize($_line);
	}
	
	public function getClassName() {
		return $this->className;
	}
	public function getExtendedClassName() {
		return $this->extendClassName . '';
	}
	
	public function __toString() {
		return '';
	}
	
	public function kind() {
		return 'class';
	}
	
	public function getMethodAST($methodName) {
		foreach ($this->classStatements as $classStatement) {
			if ($classStatement instanceof AOWP_PHPMethodElement &&
				$classStatement->getMethodName() == $methodName) {
				return $classStatement;
			} 
		}
		return null;
	}
	
	/**
	 * $elementは、{@link AOWP_PHPMethodElement}や、{@link AOWP_PHPClassVariableElement}等。
	 * 
	 * @param $element
	 * @return void
	 */
	public function addStatement(AOWP_PHPElement $element) {
		$this->classStatements[] = $element;
	}
}
?>
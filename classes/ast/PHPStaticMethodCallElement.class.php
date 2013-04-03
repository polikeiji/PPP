<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */
class AOWP_PHPStaticMethodCallElement extends AOWP_PHPElement {
	public  $className;
	public  $functionName;
	public  $arguments;
	
	public function __construct($lineOrClassName, $classNameOrFunctionName, $functionName = null, $arguments = null) {
		if ($functionName !== null && $arguments !== null) {
			$this->className		= $classNameOrFunctionName;
			$this->functionName 	= $functionName;
			$this->arguments 		= $arguments;
		}
		else {
			$this->className = new AOWP_Token($lineOrClassName);
			$this->functionName = new AOWP_Token($classNameOrFunctionName);
			$this->arguments = array();
		}
		$this->initialize($lineOrClassName);
	}

	public function addScalarArgument($scalarArgument) {
		$this->arguments[] = AOWP_PHPArgumentElement::createStringArgument($scalarArgument);
	}
	
	public function addVariableArgument($variableName) {
		$this->arguments[] = new AOWP_PHPVariableElement($variableName);
	}
	
	public function kind() {
		return "static_method_call";
	}

	public function __toString() {
		return "";
	}
}
?>

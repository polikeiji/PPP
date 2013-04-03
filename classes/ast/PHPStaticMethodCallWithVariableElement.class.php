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
class AOWP_PHPStaticMethodCallWithVariableElement extends AOWP_PHPElement
{
	public  $className;
	public  $variable;
	public  $arguments;
	
	public function __construct($line, $className, $variable, $arguments)
	{
		$this->className		= $className;
		$this->variable		 	= $variable;
		$this->arguments 		= $arguments;
		$this->initialize($line);
	}

	public function kind()
	{
		return "static_method_call_with_variable";
	}

	public function __toString()
	{
		return "";
	}
}
?>

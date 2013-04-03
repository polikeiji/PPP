<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */
/**
 * Temporal implmements...
 * 
 * <code>
 * function_call(A) ::= 
 * 		T_STRING(B) LPAREN function_call_parameter_list(C) RPAREN. {}
 * </code>
 * 
 * @package aowp.parser.ast
 */
class AOWP_PHPFunctionCallWithVariableElement extends AOWP_PHPElement
{
	public  $variable;
	public  $arguments;
	
	public function __construct($_line, $variable, $arguments)
	{
		$this->variable		 	= $variable;
		$this->arguments 		= $arguments;
		$this->initialize($_line);
	}

	public function __toString()
	{
		return "";  	  
	}
	
	public function kind()
	{
		return "function_call_with_variable";
	}
}
?>

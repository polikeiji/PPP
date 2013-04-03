<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */
/**
 * 関数呼び出しを表すAST。
 * <code>
 * function_call(A) ::= 
 * 		T_STRING(B) LPAREN function_call_parameter_list(C) RPAREN. {}
 * </code>

 * @package aowp.parser.ast
 */
class AOWP_PHPFunctionCallElement extends AOWP_PHPElement {
	/**
	 * 関数名。
	 * 
	 * @var string
	 */
	public  $functionName;
	
	/**
	 * {@link AOWP_PHPArgumentElement}の配列。
	 * 
	 * @var array
	 */
	public  $arguments;
	
	public function __construct($_lineOrFunctionName, $functionName = null, $arguments = null) {
		if ($functionName !== null && $arguments !== null) {
			$this->functionName = $functionName;
			$this->arguments = $arguments;
		}
		else {
			$this->functionName = new AOWP_Token($_lineOrFunctionName);
			$this->arguments = array();
		}
		$this->initialize($_lineOrFunctionName);
	}
	
	/**
	 * 変数の引き数を、追加する。
	 * 
	 * @param string $variableName
	 * @return void
	 */
	public function addVariableArgument($variableName) {
		$argumentElement = new AOWP_PHPArgumentElement();
		$argumentElement->expr = new AOWP_PHPVariableElement($variableName);
		$this->arguments[] = $argumentElement;
	}
	
	/**
	 * $stringOrNumber は文字列か数値。
	 * 
	 * @param $stringOrNumber
	 * @return void
	 */
	public function addScalarArgument($stringOrNumber) {
		$argumentElement = AOWP_PHPArgumentElement::createStringArgument($stringOrNumber);
		$this->addArgument($argumentElement);
	}
	
	public function addConstScalarArgument($constVariableName) {
		$argumentElement = AOWP_PHPArgumentElement::createScalarArgument($constVariableName);
		$this->addArgument($argumentElement);
	}
	
	public function addArgument(AOWP_PHPArgumentElement $argument) {
		$this->arguments[] = $argument;
	}
	
	public function getArguments() {
		return $this->arguments;
	}
	
	/**
	 * 
	 * @return int
	 */
	public function getArgumentCount() {
		return count($this->arguments);
	}
	
	public function getFunctionName() {
		return $this->functionName->getValue();
	}

	public function __toString() {
		return "";
	}
	
	public function kind() {
		return "function_call";
	}
}
?>

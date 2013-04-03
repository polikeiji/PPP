<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPParamaterElement
 *
 * PHPのASTにおける「仮引数」を表すクラス
 * 文法規則: parameter_list
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPParamaterElement extends AOWP_PHPElement {
	
	/**
	 * 
	 * @var AOWP_PHPVariableElement
	 */
	public $paramaterName;
	public $classTypeName;
	public $initialValue;

	public function __construct($_lineOrParameterName, $classTypeNameOrInitialValue = null, $paramaterNameOrClassTypeName = null, $initialValue = null) {
		if (is_numeric($_lineOrParameterName) && 
			($paramaterNameOrClassTypeName instanceof AOWP_PHPVariableElement || $paramaterNameOrClassTypeName instanceof AOWP_PHPAmpersandExprElement)) {
			$this->paramaterName = $paramaterNameOrClassTypeName;
			$this->classTypeName = $classTypeNameOrInitialValue;
			$this->initialValue  = $initialValue;
		}
		else {
			$this->paramaterName = new AOWP_PHPVariableElement($_lineOrParameterName);
			$this->initialValue = $classTypeNameOrInitialValue;
			$this->classTypeName = $paramaterNameOrClassTypeName;
		}
		$this->initialize($_lineOrParameterName);
	}
	
	public function getParameterName() {
		return $this->paramaterName->getVariableName();
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return 'paramater';
	}

}
?>
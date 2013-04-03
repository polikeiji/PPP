<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPFunctionElement
 *
 * PHPのASTにおける「関数」を表すクラス
 * 文法規則: unticked_function_declaration_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPFunctionElement extends AOWP_PHPInnerStatementContainerElement {
	
	public $isReference;
	
	/**
	 * {@link AOWP_Token} (未確認。他にも来るかも。)。
	 * 
	 * @var AOWP_Token
	 */
	public $functionName;

	/**
	 * {@link AOWP_PHPParamaterElement}の配列
	 * 
	 * @var array
	 */
	public $paramaters;
	
	public function __construct($_lineOrFunctionName, $isReference = null, $functionName = null, $paramaters = null, $innerStatements = null) {
		if ($isReference !== null && $functionName !== null &&
			$paramaters !== null && $innerStatements !== null) {
			$this->isReference		= $isReference;
			$this->functionName 	= $functionName;
			$this->paramaters		= $paramaters;
			$this->innerStatements 	= $innerStatements;
		}
		else {
			$this->functionName = new AOWP_Token($_lineOrFunctionName);
			$this->paramaters = array();
			$this->innerStatements = array();
		}
		$this->initialize($_lineOrFunctionName);
	}
	
	/**
	 * 
	 * @param $parameterName
	 * @param $initialValue
	 * @param $classTypeName
	 * @return unknown_type
	 */
	public function addParameter($parameterName, $initialValue = null, $classTypeName = null) {
		$this->paramaters[] = new AOWP_PHPParamaterElement($parameterName, $initialValue, $classTypeName);
	}
	
	public function addAmpersandParameter($parameterName, $initialValue = null, $classTypeName = null) {
		$this->paramaters[] = new AOWP_PHPAmpersandExprElement(new AOWP_PHPParamaterElement($parameterName, $initialValue, $classTypeName));
	}
	
	/**
	 * 関数名を取得します。
	 * 
	 * @return string
	 */
	public function getFunctionName() {
		return $this->functionName->__toString();
	}
	
	/**
	 * 引き数で指定した、このインスタンスが表す関数の引き数の名前を、取得します。
	 * 引き数で指定した、引き数が無い場合、nullを返します。
	 * 
	 * @param int $index
	 * @return string or null
	 */
	public function getParameterName($index) {
		if (isset($this->paramaters[$index])) {
			return $this->paramaters[$index]->getParameterName();
		}
		else {
			return null;
		}
	}
	
	public function getParameterCount() {
		return count($this->paramaters);
	}
	
	public function __toString() {
		return "";
	}
	
	public function kind() {
		return 'function';
	}
}
?>
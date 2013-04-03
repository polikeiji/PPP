<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPVariableElement
 *
 * PHPのASTにおける「変数」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPVariableElement extends AOWP_PHPElement implements AOWP_IPHPVariable {
	/**
	 * {@link AOWP_Token} (他の型の可能性も。要調査)。
	 * $も含めた変数名を、設定します。
	 * 
	 * @var AOWP_Token
	 */
	public $variableName;

	/**
	 * 
	 * @param $_lineOrVariableName
	 * @param $variableName
	 * @return unknown_type
	 */
	public function __construct($_lineOrVariableName, $variableName = null) {
		if ($variableName !== null) {
			$this->variableName	 = $variableName;
		}
		else {
			$this->setVariableName($_lineOrVariableName);
		}	
		$this->initialize($_lineOrVariableName);
	}
	
	/**
	 * 
	 * @see parser/ast/util/AOWP_IPHPVariable#setVariableName()
	 */
	public function setVariableName($variableName) {
		$this->variableName = new AOWP_Token($variableName);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getVariableName() {
		return $this->variableName->__toString();
	}
	
	public function __toString()
	{
		return "";
	}	
	
	public function kind()
	{
		return 'variable';
	}
}
?>
<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPIfStatementElement
 *
 * PHPのASTにおける「if」を表すクラス
 * 文法規則: unticked_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPIfStatementElement extends AOWP_PHPElement implements AOWP_ITagStatementElement {
	/**
	 * {@link AOWP_PHPObjectOperatorElement}等 (要調査)。
	 * 
	 * @var AOWP_PHPElement
	 */
	public $condition;
	/**
	 * 
	 * @var AOWP_PHPInnerStatementElement
	 */
	public $innerStatements;
	/**
	 * 
	 * @var AOWP_PHPElseIfStatementElement
	 */
	public $elseifStatements;
	/**
	 * 
	 * @var AOWP_PHPInnerStatementElement
	 */
	public $elseStatements;
	
	public function __construct($_line = null, $condition = null, $innerStatements = null, $elseifStatements = null, $elseStatements = null) {
		$this->condition 		= $condition;
		$this->innerStatements 	= $innerStatements;
		$this->elseifStatements = $elseifStatements;
		$this->elseStatements 	= $elseStatements;
		$this->initialize($_line);
	}
	
	public function setIfStatements(array $ifStatements) {
		$this->innerStatements = array(new AOWP_PHPInnerStatementElement($ifStatements));
	}
	
	public function setCondition(AOWP_PHPElement $condition) {
		$this->condition = $condition;
	}
	
	/**
	 * $elementは、PHPの文章となりうる、Statement系のASTインスタンス。
	 * 
	 * @param $element
	 * @return void
	 */
	public function addStatement(AOWP_PHPElement $element) {
		$this->_setupIfStatementArray();
		$this->innerStatements[0]->setElement($element);
	}
	
	public function addStatementArray(array $elements, $indexOrElement = null) {
		$this->_setupIfStatementArray();
		$this->innerStatements[0]->insertElementArray($elements, $indexOrElement);
	}

	public function existInIfStatement(AOWP_PHPElement &$element) {
		$this->_setupIfStatementArray();
		$result = (isset($this->innerStatements[0]) != null && $this->innerStatements[0] instanceof AOWP_PHPInnerStatementElement) ?
			$this->innerStatements[0]->searchElementIndex($element) !== null : false;
		return $result;
	}
		
	private function _setupIfStatementArray() {
		if (!isset($this->innerStatements)) {
			$this->innerStatements = array(new AOWP_PHPInnerStatementElement());
		}
		else if ($this->innerStatements instanceof AOWP_PHPElement) {
			$this->innerStatements = array(new AOWP_PHPInnerStatementElement(array($this->innerStatements)));
		}
		else if (is_array($this->innerStatements) && count($this->innerStatements) == 0) {
			$this->innerStatements = array(new AOWP_PHPInnerStatementElement());
		}
	}
	
	public function addElseStatement(AOWP_PHPElement $element) {
		$this->_setupElseStatementArray();
		$this->elseStatements[0]->setElement($element);
	}
	
	public function addElseStatementArray(array $elements, $indexOrElement = null) {
		$this->_setupElseStatementArray();
		$this->elseStatements[0]->insertElementArray($elements, $indexOrElement);
	}
	
	private function _setupElseStatementArray() {
		if (!isset($this->elseStatements)) {
			$this->elseStatements = array(new AOWP_PHPInnerStatementElement());
		}
		else if ($this->elseStatements instanceof AOWP_PHPElement) {
			$this->elseStatements = array(new AOWP_PHPInnerStatementElement(array($this->elseStatements)));
		}
		else if (is_array($this->elseStatements) && count($this->elseStatements) == 0) {
			$this->elseStatements = array(new AOWP_PHPInnerStatementElement());
		}
	}
	
	public function __toString() {
		return "";
	}
	
	public function kind() {
		return 'if';
	}
}
?>
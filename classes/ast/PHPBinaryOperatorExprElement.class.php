<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPBinaryOperatprExprElement
 *
 * PHPのASTにおける「２項演算子」を表すクラス
 * 文法規則: unticked_statement
 * 例：		$a + 2;
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPBinaryOperatorExprElement extends AOWP_PHPElement {
	const DOT = '.';
	
	public $leftExpr;
	public $operatorName;
	public $rightExpr;

	public function __construct($_line = null, $leftExpr = null, $operatorName = null, $rightExpr = null) {
		$this->leftExpr		 = $leftExpr;
		$this->operatorName	 = $operatorName;
		$this->rightExpr	 = $rightExpr;
		$this->initialize($_line);
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return $this->operatorName;
	}
	
	public function setLeftExpr(AOWP_PHPElement $element) {
		$this->leftExpr = $element;
		$this->leftExpr->setParentInfo($this, 'leftExpr');
	}
	public function addRightExpr(AOWP_PHPElement $rightExpr, $operatorName) {
		if ($this->rightExpr === null || $this->operatorName === null) {
			$this->operatorName = $operatorName;
			$this->rightExpr = $rightExpr;
			$this->rightExpr->setParentInfo($this, 'rightExpr');
		}
		else {
			$addedBinaryOperatorExpr = new AOWP_PHPBinaryOperatorExprElement($this->line(), $this->leftExpr, $this->operatorName, $this->rightExpr);
			$this->leftExpr = $addedBinaryOperatorExpr;
			$this->leftExpr->setParentInfo($this, 'leftExpr');
			$this->operatorName = $operatorName;
			$this->rightExpr = $rightExpr;
			$this->rightExpr->setParentInfo($this, 'rightExpr');
		}
	}
	
	public function addScalarRightExpr($rightExprString, $operatorName) {
		$this->addRightExpr(new AOWP_PHPScalarExprElement($rightExprString), $operatorName);
	}
}
?>
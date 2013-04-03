<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPのASTにおける「include, require」を表すクラス。
 * 文法規則: unticked_statement。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPFileIncludeStatementElement extends AOWP_PHPElement {
	const TYPE_REQUIRE = 'require';
	const TYPE_REQUIRE_ONCE = 'require_once';
	const TYPE_INCLUDE = 'include';
	const TYPE_INCLUDE_ONCE = 'include_once';
	
	/**
	 * 
	 * @var string
	 */
	public 	$type;

	/**
	 * <code>
	 * require_once 'sample.php';
	 * require $a;
	 * include_once $b['a'];
	 * include $a->b();
	 * </code>
	 * 上から順に、{@link AOWP_PHPScalarExprElement}、{@link AOWP_PHPVariableElement}、
	 * {@link AOWP_PHPReferenceVariableElement}、{@link AOWP_PHPObjectOperatorElement}。
	 * 
	 * @var AOWP_PHPElement
	 */
	public $expr;

	public function __construct($_line = null, $type = null, $expr = null) {
		$this->type			 = $type;
		$this->expr			 = $expr;
		$this->initialize($_line);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getScalarExprFileName() {
		if ($this->expr instanceof AOWP_PHPScalarExprElement) {
			return $this->expr->getScalar();
		}
		else {
			return null;
		}
	}
	
	/**
	 * 
	 * @param string $exprString
	 * @return void
	 */
	public function setScalarExpr($exprString) {
		$this->expr = new AOWP_PHPScalarExprElement("'" . $exprString . "'");
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return $this->type;
	}
}
?>
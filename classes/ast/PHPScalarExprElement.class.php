<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPのASTにおける「scalar」を表すクラス。
 * 'A'や 1 等の値を表す。
 * 文法規則: common_scalar。
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 */
class AOWP_PHPScalarExprElement extends AOWP_PHPElement
{
	/**
	 * {@link AOWP_Token}等?
	 * @var mixed
	 */
	public	$scalar;

	/**
	 * 1番目の引き数は、string or int。
	 * 2番目の引き数は、{@link AOWP_PHPScalarExprElement}。
	 * もし、第2引き数を省略した場合、
	 * 1番目の引き数は、{@link AOWP_PHPScalarExprElement} の内容を表す文字列として取り扱われます。
	 * 
	 * @param $_lineOrScalarString
	 * @param $scalar
	 * @return void
	 */
	public function __construct($_lineOrScalarString, $scalar = null) {
		if ($scalar !== null) {
			$this->scalar = $scalar;
		}
		else {
			$this->scalar = new AOWP_Token($_lineOrScalarString);
		}
		$this->initialize($_lineOrScalarString);
	}
	
	public function getScalar() {
		return $this->scalar->__toString();
	}
	
	public function __toString() {
		return "";
	}	
	
	public function kind() {
		return 'scalar';
	}
}
?>
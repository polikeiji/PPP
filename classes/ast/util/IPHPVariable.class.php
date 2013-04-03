<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast.util
 */
/**
 * 変数を表すASTインスタンスが、実装すべきインターフェース。
 * 
 * @author keiji
 * @package aowp.parser.ast.util
 */
interface AOWP_IPHPVariable {

	/**
	 * 変数名を変更します。
	 * 
	 * @param string $variableName
	 * @return void
	 */
	public function setVariableName($variableName);
}
?>
<?php/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */
/** * PHPのASTにおける「declare」を表すクラス。 * 文法規則: unticked_statement。 * * @package aowp.parser.ast * @access  public * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp> * */class AOWP_PHPDeclareStatementElement extends AOWP_PHPStatementContainerElement implements AOWP_ITagStatementElement {
	public	$declares;
	public function __construct($_line, $declares, $statements) {
		$this->declares 	= $declares;
		$this->statements 	= $statements;
		$this->initialize($_line);
	}
			public function __toString() {
		return "";
	}	
	
	public function kind() {
		return 'declare';
	}
}?>
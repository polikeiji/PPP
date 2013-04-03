<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPInterfaceElement
 *
 * PHPのASTにおける「インターフェイス」を表すクラス
 * 文法規則: unticked_class_declaration_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPInterfaceElement extends AOWP_PHPElement
{
	public $interfaceName;
	public $extendClassNames;
	public $classStatements;
	
	public function __construct($_line, $interfaceName, $extendClassNames, $classStatements)
	{
		$this->interfaceName 			= $interfaceName;
		$this->extendClassNames			= $extendClassNames;
		$this->classStatements			= $classStatements;
		$this->initialize($_line);
	}
	
	public function __toString()
	{
		return "";
	}

	public function kind()
	{
		return 'interface';
	}
}
?>
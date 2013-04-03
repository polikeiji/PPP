<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */
class AOWP_PHPStaticMemberRefElement extends AOWP_PHPElement
{
	public  $className;
	public  $variable;
	
	public function __construct($line, $className, $variable)
	{
		$this->className		= $className;
		$this->variable			= $variable;
		$this->initialize($line);
	}

	public function kind()
	{
		return "static_member_ref";
	}

	public function __toString()
	{
		return "";
	}
}
?>

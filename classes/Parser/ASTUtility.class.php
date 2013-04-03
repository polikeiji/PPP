<?php
/**
 * 短い説明
 * 
 * 長い説明
 * 
 * @package aowp.parser.Parser
 */
/**
 * 短い説明
 * 
 * 長い説明
 * 
 * @package aowp.parser.Parser
 */
class AOWP_ASTUtility {
	
	static function isASTElement(&$ast){
		return $ast instanceof AOWP_PHPElement;
	}
	
	static function isToken(&$ast){
		return $ast instanceof AOWP_Token;
	}
	
	static function isArrayElement(&$ast){
		return is_array($ast);
	}
	
	static function isNullElement(&$ast){
		return $ast === null;
	}
}
?>
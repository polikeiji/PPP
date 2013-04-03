<?php
/**
 * 短い説明
 * 長い説明
 * 
 * @package aowp.parser.Parser
 */
/**
 * 文字列等の、PHPのトークンを表すAST要素。
 * 
 * @package aowp.parser.Parser
 */
class AOWP_Token {
	
	private $_value;
	private $_valueWithWhiteSpace;
	private $_line;
	private $_metadata;
	
	public function __construct($value, $valueWithWhiteSpace = null, $line = null, $metadata = array()){
		$this->_value 				= $value;
		$this->_valueWithWhiteSpace = $valueWithWhiteSpace;
		$this->_line 				= $line;
		$this->_metadata			= $metadata;
	}
	
	public function __toString() {
		return $this->_value . '';
	}
	
	public function getValue() {
		return $this->_value;
	}
	
	public function getLine() {
		return $this->_line;
	}
	
	public function getMetadata() {
		return $this->_metadata;
	}
}
?>
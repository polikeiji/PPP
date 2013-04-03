<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

/**
 * PHPElement
 *
 * PHPの文法要素のインターフェイス
 * 文法規則: unticked_class_declaration_statement
 *
 * @package aowp.parser.ast
 * @access  public
 * @author  Ryoto Naruse <naruse@minnie.ai.kyutech.ac.jp>
 *
 */
class AOWP_PHPElement {
	private $parent = null;
	private $propertyName = '';
	private $propertyIndex = -1;
	private $_line = 0;
	
	//getParentPropertyIndexの戻り値
	//配列ではないことをあらわす
	const NO_ARRAY = -1;
	
	/**
	 * 行番号の初期化と、このASTインスタンスの子の要素に、自身を親として登録する。
	 * 
	 * @param int $_line 行番号
	 */
	protected function initialize($_line) {
		// 行番号
		$this->_line = is_numeric($_line) ? $_line : $this->_line;
		
		// それぞれの要素に親を設定
		foreach(get_object_vars($this) as $varName => $property) {
			if (AOWP_ASTUtility::isArrayElement($property)){
				for ($i = 0; $i < count($property); $i++){
					if (AOWP_ASTUtility::isASTElement($property[$i])){
						$property[$i]->setParentInfo($this, $varName, $i);
					}
				}
			}
			else if (AOWP_ASTUtility::isASTElement($property)){
				$property->setParentInfo($this, $varName);
			}
		}		
	}
	public function setParentInfo($parent, $propertyName = '', $propertyIndex = AOWP_PHPElement::NO_ARRAY) {
//		echo "\t" . 'parent: ' . get_class($parent) . ', propertyName: ' . $propertyName . ', propertyIndex: ' . $propertyIndex . "\n";
		$this->parent = $parent;
		$this->propertyName	= $propertyName;
		$this->propertyIndex = $propertyIndex;
	}
	public function setParent(AOWP_PHPElement $parent) {
		$this->parent = $parent;
	}
	public function line(){
		return $this->_line;
	}
	public function __toString(){
		return "";
	}
	public function kind(){
		return "element";
	}
	public function &getParent() {
		return $this->parent;
	}
	
	public function getParentContainer() {
		echo get_class($this) . ": " . get_class($this->parent) . "\n";
		if ($this->parent == null) {
			return null;
		}
		else if ($this->parent instanceof AOWP_PHPInnerStatementContainerElement) {
			return $this->parent;
		}
		else {
			return $this->parent->getParentContainer();
		}
	}
	
	public function getParentPropertyName() {
		return $this->propertyName;
	}
	public function getParentPropertyIndex() {
		return $this->propertyIndex;
	}
	public function getChildren() {
		$childArray = array();
		$containerChildArray = array();
		foreach(get_object_vars($this) as $varName => $property) {
			if ($varName != 'parent') {
				if ($property instanceof AOWP_PHPElement) {
					$childArray[] = $property;
				}
				else if (is_array($property)) {
					foreach ($property as &$elementInProperty) {
						if ($elementInProperty instanceof AOWP_PHPElement) {
							$containerChildArray[] = $elementInProperty;
						}
					}
				}
			}
		}
		return array_merge($childArray, $containerChildArray);
	}
	public function releaseInstance() {
		foreach(get_object_vars($this) as $varName => $property) {
			if (AOWP_ASTUtility::isArrayElement($property)){
				foreach($property as $propertyInArray){
					if(AOWP_ASTUtility::isASTElement($propertyInArray)){
						$propertyInArray->releaseInstance();
					}
				}
			}
			else if (AOWP_ASTUtility::isASTElement($property) && $varName != 'parent') {
				$property->releaseInstance();
			}
			$this->$varName = null;
		}
	}
	
	public function __clone() {
        foreach ($this as $name => $value) {
        	if ($name === 'parent' || $name === 'propertyIndex' || $name === 'propertyName') {
        		$this->$name = null;
        	}
            else if (gettype($value) == 'object') { 
            	$this->$name = clone ($this->$name); 
            } 
        } 
	}
}
?>
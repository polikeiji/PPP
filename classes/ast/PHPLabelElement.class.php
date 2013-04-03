<?php
class AOWP_PHPLabelElement extends AOWP_PHPElement {

	private $_label;
	
	public function __construct($label) {
		$this->_label = $label;
	}
	
	public function getLabel() {
		return $this->_label;
	}
}
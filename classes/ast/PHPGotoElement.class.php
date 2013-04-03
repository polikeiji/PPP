<?php
/**
 * 
 * @author keiji
 *
 */
class AOWP_PHPGotoElement extends AOWP_PHPElement {
	
	private $_toLabel;
	
	public function __construct($toLabel) {
		$this->_toLabel = $toLabel;
	}
	
	public function getToLabel() {
		return $this->_toLabel;
	}
}
?>
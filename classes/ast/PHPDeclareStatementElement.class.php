<?php
 * Enter description here...
 *
 * @package aowp.parser.ast
 */

	public	$declares;
	public function __construct($_line, $declares, $statements) {
		$this->declares 	= $declares;
		$this->statements 	= $statements;
		$this->initialize($_line);
	}
		
		return "";
	}	
	
	public function kind() {
		return 'declare';
	}
}
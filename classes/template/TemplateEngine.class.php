<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.template
 */

/**
 * Enter description here...
 *
 * @package aowp.parser.template
 */
class AOWP_TemplateEngine {
	
	private static function _templatePath($astClassName) {
		return 'templateFiles/' . strtolower($astClassName) . '.php';
	}
	
	public static function scriptToSource(&$rootAST) {
		ob_start();
		error_reporting(E_ALL);
		AOWP_TemplateEngine::toSource($rootAST);
		return ob_get_clean();
	}
	
	public static function toSource(&$element, $arraySeparateComma = false, $delimiter = ', ') {
		if (AOWP_ASTUtility::isASTElement($element)) {
			$ast = $element;
			include(AOWP_TemplateEngine::_templatePath(get_class($element)));
		}
		else if (is_string($element) || AOWP_ASTUtility::isToken($element)) {
			echo $element;
		}
		else if (AOWP_ASTUtility::isArrayElement($element)) {
			$multipleFlag = false;
			foreach ($element as $elementInArray) {
				if ($arraySeparateComma) {
					if ($multipleFlag) {
						echo $delimiter;
					}
					else if (!$multipleFlag) {
						$multipleFlag = true;
					}
				}
				AOWP_TemplateEngine::toSource($elementInArray);
			}
		}
	}
}

?>
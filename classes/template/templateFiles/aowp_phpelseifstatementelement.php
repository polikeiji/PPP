<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
else if (<?php AOWP_TemplateEngine::toSource($ast->condition); ?>) {
<?php 
foreach($ast->innerStatements as $astInStatements){
	AOWP_TemplateEngine::toSource($astInStatements); 
}
?>
} 

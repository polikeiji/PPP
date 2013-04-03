<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
while (<?php AOWP_TemplateEngine::toSource($ast->condition); ?>) {
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
}

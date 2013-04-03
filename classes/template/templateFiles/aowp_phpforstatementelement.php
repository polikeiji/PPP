<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
for(<?php AOWP_TemplateEngine::toSource($ast->initialExprs, true); ?>; <?php AOWP_TemplateEngine::toSource($ast->conditions, true); ?>; <?php AOWP_TemplateEngine::toSource($ast->updateExprs, true); ?>) {
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
}

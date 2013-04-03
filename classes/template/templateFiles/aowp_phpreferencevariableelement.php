<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->variable); ?><?php echo '[' ?><?php AOWP_TemplateEngine::toSource($ast->indexExpr) ?><?php echo ']' ?>
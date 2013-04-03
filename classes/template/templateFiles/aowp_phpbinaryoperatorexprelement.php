<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->leftExpr); ?> <?php AOWP_TemplateEngine::toSource($ast->operatorName); ?> <?php AOWP_TemplateEngine::toSource($ast->rightExpr); ?>
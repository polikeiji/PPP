<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->keyExpr); ?><?php echo $ast->keyExpr != null ? ' => ' : '' ?><?php AOWP_TemplateEngine::toSource($ast->valueExpr); ?>
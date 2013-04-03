<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php echo $ast->classTypeName != null ? $ast->classTypeName . ' ' : '' ?><?php AOWP_TemplateEngine::toSource($ast->paramaterName); ?><?php echo $ast->initialValue != null ? ' = ' : '' ?><?php AOWP_TemplateEngine::toSource($ast->initialValue) ?>
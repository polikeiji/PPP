<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->propertyName); ?><?php echo is_array($ast->arguments) ? '(' : '' ?><?php echo AOWP_TemplateEngine::toSource($ast->arguments, true); ?><?php echo is_array($ast->arguments) ? ')' : '' ?>
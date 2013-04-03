<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php echo AOWP_TemplateEngine::toSource($ast->className) ?>::<?php echo AOWP_TemplateEngine::toSource($ast->functionName) ?>(<?php echo AOWP_TemplateEngine::toSource($ast->arguments, true) ?>)
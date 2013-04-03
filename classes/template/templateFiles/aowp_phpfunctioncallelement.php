<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->functionName); ?>(<?php AOWP_TemplateEngine::toSource($ast->arguments, true); ?>)
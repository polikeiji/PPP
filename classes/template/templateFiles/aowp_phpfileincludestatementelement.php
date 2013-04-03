<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php echo $ast->type ?>(<?php echo AOWP_TemplateEngine::toSource($ast->expr) ?>)
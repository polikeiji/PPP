<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
try{
<?php echo AOWP_TemplateEngine::toSource($ast->innerStatements) ?>
}
<?php echo AOWP_TemplateEngine::toSource($ast->catchStatements) ?>
<?php echo "\n" ?>
<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>

do{
<?php echo AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
}while(<?php echo AOWP_TemplateEngine::toSource($ast->condition); ?>);
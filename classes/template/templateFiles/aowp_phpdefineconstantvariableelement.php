<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php echo AOWP_TemplateEngine::toSource($ast->variableName); ?> = <?php echo AOWP_TemplateEngine::toSource($ast->initialValue); ?>
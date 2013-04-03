<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->expr) ?><?php echo '->' ?><?php AOWP_TemplateEngine::toSource($ast->objectProperties, true, '->') ?>

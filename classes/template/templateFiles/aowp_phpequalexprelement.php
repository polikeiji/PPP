<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->variable); ?> <?php echo $ast->operatorName ?> <?php AOWP_TemplateEngine::toSource($ast->expr); ?>
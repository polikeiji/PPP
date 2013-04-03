<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
catch (<?php echo AOWP_TemplateEngine::toSource($ast->className) ?> <?php echo AOWP_TemplateEngine::toSource($ast->variable) ?>){
<?php echo AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
}
<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
elseif( <?php echo AOWP_TemplateEngine::toSource($ast->condition); ?> ):
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
if( <?php echo AOWP_TemplateEngine::toSource($ast->condition); ?> ):
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
<?php AOWP_TemplateEngine::toSource($ast->elseifStatements); ?>
<?php AOWP_TemplateEngine::toSource($ast->elseStatement); ?>
<?php if($ast->innerStatements != null): ?>
endif;
<?php endif; ?>
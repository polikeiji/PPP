<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php if(is_string($ast->expr) && $ast->expr == 'default'): ?>
default:
<?php else: ?>
case  <?php echo AOWP_TemplateEngine::toSource($ast->expr); ?>:
<?php endif; ?>
<?php
	AOWP_TemplateEngine::toSource($ast->innerStatements);
?>
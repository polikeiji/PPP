<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php echo AOWP_TemplateEngine::toSource($ast->modifiers, true, ' '); ?> function <?php echo $ast->isReference ? '&' : '' ?><?php echo $ast->functionName ?>(<?php AOWP_TemplateEngine::toSource($ast->paramaters, true) ?>)<?php echo $ast->innerStatements === null ? ";" : '' ?>

<?php if($ast->innerStatements !== null): ?>
{
<?php
	AOWP_TemplateEngine::toSource($ast->innerStatements);
?>
}
<?php endif; ?>

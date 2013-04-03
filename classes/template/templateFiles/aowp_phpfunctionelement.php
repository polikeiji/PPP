<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
function <?php echo $ast->isReference ? '&' : '' ?><?php echo $ast->functionName ?>(<?php AOWP_TemplateEngine::toSource($ast->paramaters, true); ?>) {
	<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
}


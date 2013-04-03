<?php
/**
 * Enter description here...
 *
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->modifiers, true, ' '); ?><?php echo count($ast->modifiers) > 0 ? ' ' : '' ?><?php AOWP_TemplateEngine::toSource($ast->variables, true) ?>;

<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php AOWP_TemplateEngine::toSource($ast->type) ?> <?php AOWP_TemplateEngine::toSource($ast->variables, true) ?>;

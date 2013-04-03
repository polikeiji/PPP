<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
new <?php echo AOWP_TemplateEngine::toSource($ast->className) ?>(<?php echo AOWP_TemplateEngine::toSource($ast->arguments, true) ?>)
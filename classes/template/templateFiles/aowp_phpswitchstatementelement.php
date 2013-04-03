<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
switch (<?php echo AOWP_TemplateEngine::toSource($ast->expr); ?>) {
<?php
AOWP_TemplateEngine::toSource($ast->caseStatements);
?>
}

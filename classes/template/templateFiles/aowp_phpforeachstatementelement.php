<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
foreach (<?php AOWP_TemplateEngine::toSource($ast->expr); ?> as <?php AOWP_TemplateEngine::toSource($ast->foreachVariable); ?><?php echo $ast->optionalArg != null ? ' => ' : '' ?><?php AOWP_TemplateEngine::toSource($ast->optionalArg) ?>) {
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
}

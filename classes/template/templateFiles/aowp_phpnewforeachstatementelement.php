<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
<?php if($ast->innerStatements == null): ?>
foreach (<?php AOWP_TemplateEngine::toSource($ast->expr); ?> as <?php AOWP_TemplateEngine::toSource($ast->foreachVariable); ?><?php echo $ast->optionalArg != null ? ' => ' : '' ?><?php AOWP_TemplateEngine::toSource($ast->optionalArg) ?>):
<?php else: ?>
foreach (<?php AOWP_TemplateEngine::toSource($ast->expr); ?> as <?php AOWP_TemplateEngine::toSource($ast->foreachVariable); ?><?php echo $ast->optionalArg != null ? ' => ' : '' ?><?php AOWP_TemplateEngine::toSource($ast->optionalArg) ?>):
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
endforeach;
<?php endif; ?>
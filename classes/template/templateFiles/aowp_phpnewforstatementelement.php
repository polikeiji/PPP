<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
<?php if($ast->innerStatements ==null ): ?>
for(<?php AOWP_TemplateEngine::toSource($ast->initialExprs, true); ?>; <?php AOWP_TemplateEngine::toSource($ast->conditions, true); ?>; <?php AOWP_TemplateEngine::toSource($ast->updateExprs, true); ?>):
<?php else: ?>
for(<?php AOWP_TemplateEngine::toSource($ast->initialExprs, true); ?>; <?php AOWP_TemplateEngine::toSource($ast->conditions, true); ?>; <?php AOWP_TemplateEngine::toSource($ast->updateExprs, true); ?>):
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
endfor;
<?php endif; ?>

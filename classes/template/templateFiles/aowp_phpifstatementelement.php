<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
if(<?php AOWP_TemplateEngine::toSource($ast->condition); ?>) {
<?php AOWP_TemplateEngine::toSource($ast->innerStatements); ?>
}
<?php AOWP_TemplateEngine::toSource($ast->elseifStatements); ?>
<?php
if( count($ast->elseStatements) != 0 ){
?>
else{
<?php AOWP_TemplateEngine::toSource($ast->elseStatements); ?>
}
<?php
}
?>

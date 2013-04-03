<?php
/**
 * 短い説明
 * 
 * 長い説明
 * 
 * @package aowp.parser.template
 */
?>
<?php echo $ast->openCurly; ?><?php echo AOWP_TemplateEngine::toSource($ast->expr); ?>}
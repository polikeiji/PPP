<?php
/**
 * 短い説明
 * 
 * 長い説明
 * 
 * @package aowp.parser.template
 */
?>
<<< <?php echo $ast->docName . "\n" ?>
<?php echo AOWP_TemplateEngine::toSource($ast->encaps); ?>
<?php echo $ast->docName ?>
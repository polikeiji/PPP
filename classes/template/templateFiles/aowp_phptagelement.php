<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php echo "<?php\n" ?>

<?php echo AOWP_TemplateEngine::toSource($ast->statements) ?>

<?php echo "?>\n" ?>
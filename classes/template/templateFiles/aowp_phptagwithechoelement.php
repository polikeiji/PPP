<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php echo "<?php echo\n" ?>
<?php
	foreach($ast->statements as $statement){
		AOWP_TemplateEngine::toSource($statement);
	}
?>
<?php echo "?>\n" ?>
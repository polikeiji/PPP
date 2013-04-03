<?php
/**
 * @package aowp.parser.template.templateFiles
 */
?>
<?php if($ast->innerStatements == null): ?>
	while( <?php echo AOWP_TemplateEngine::toSource($ast->condition); ?> ):
<?php else: ?>
	while( <?php echo AOWP_TemplateEngine::toSource($ast->condition); ?> ):
	<?php
		foreach($ast->innerStatements as $statement){
			AOWP_TemplateEngine::toSource($statement);
		}
		AOWP_TemplateEngine::toSource($ast->elseStatement);
	 ?>
	 endwhile;
<?php endif ?>
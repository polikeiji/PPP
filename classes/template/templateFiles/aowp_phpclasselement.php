<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */

$extendSource = $ast->extendClassName !== null ? 'extends ' . $ast->extendClassName : '';

$implementSource = null;
if (is_array($ast->implementInterfaceNames)) {
	foreach ($ast->implementInterfaceNames as $interfaceName) {
		if ($implementSource == null) {
			$implementSource = ' implements ';
		}
		else {
			$implementSource .= ', ';
		}
		$implementSource .= $interfaceName;
	}
	if ($implementSource != null) {
		$implementSource .= ' ';	
	}
}
else {
	$implementSource = '';
}
?>
<?php echo $ast->typeName ?> class <?php echo $ast->className ?> <?php echo $extendSource ?><?php echo $implementSource ?>{

<?php
AOWP_TemplateEngine::toSource($ast->classStatements);

?>	

}

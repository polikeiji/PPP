<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
$metadata = $ast->value->getMetaData();
?>
<?php 
if (isset($metadata[0]) && $metadata[0] != null) {
	echo $metadata[0] . "\n";
}
?>
<?php echo $ast->value . "\n"; ?>
<?php 
if (isset($metadata[1]) && $metadata[1] != null) {
	echo $metadata[1] . "\n";
}
?>

<?php
/**
 * 
 * 
 * @package aowp.parser.template.templateFiles
 */
?>
<?php
if (count($ast->extendClassNames) > 0) {
    $extendsSource = 'extends ';
    for ($i = 0; $i < count($ast->extendClassNames); $i++) {
        if ($i != 0) {
            $extendsSource .= ', ';
        }
        $extendsSource .= $ast->extendClassNames[$i];
    }
}
else {
    $extendsSource = '';
}
?>
interface <?php echo $ast->interfaceName ?> <?php echo $extendsSource ?>{
<?php
foreach ($ast->classStatements as $classStatementsAST) {
    AOWP_TemplateEngine::toSource($classStatementsAST);
}
?>
}

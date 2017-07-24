<?php

use Fabs\THP\PHPCompiler;
use Fabs\THP\PHPParser;

include_once dirname(__DIR__) . '/vendor/autoload.php';


$code = file_get_contents(__DIR__ . '/test.thp');
$compiler = new PHPCompiler();
echo '<code>';
var_dump($compiler->compile($code));

//var_export($parser->getRuleList());
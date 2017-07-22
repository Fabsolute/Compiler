<?php

use Fabs\Test\PHPParser;

include_once dirname(__DIR__) . '/vendor/autoload.php';


//$code = file_get_contents(__DIR__ . '/test.thp');
$parser = new PHPParser();
echo '<pre>';
var_export($parser->getRuleList());
//var_dump($parser->parse($code));

<?php


namespace Fabs\THP;


use Fabs\Compiler\Compiler;

class PHPCompiler extends Compiler
{

    /**
     * @return string
     */
    protected function getParserClass()
    {
        return PHPParser::class;
    }

    /**
     * @return string
     */
    protected function getLexerClass()
    {
        return PHPLexer::class;
    }
}

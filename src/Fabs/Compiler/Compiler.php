<?php


namespace Fabs\Compiler;


abstract class Compiler
{
    /**
     * @return string
     */
    protected abstract function getParserClass();

    /**
     * @return string
     */
    protected abstract function getLexerClass();

    public function compile($code)
    {
        $lexer_class = $this->getLexerClass();
        /** @var Lexer $lexer */
        $lexer = new $lexer_class();

        $parser_class = $this->getParserClass();
        /** @var Parser $parser */
        $parser = new $parser_class();

        return $parser->parse($code, $lexer);
    }
}
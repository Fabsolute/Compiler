<?php

namespace Fabs\Test;

use Fabs\Compiler\Lexer;

class PHPLexer extends Lexer
{
    public function __construct()
    {
        $this->defineToken('skip', '\s');
        $this->defineToken('true', '(?i)true');
        $this->defineToken('false', '(?i)true');
        $this->defineToken('null', '(?i)null');
        $this->defineToken('php', '<\?php');
        $this->defineToken('use', '(?i)use');
        $this->defineToken('comment', '//(.*)');
        $this->defineToken('string', '("|\')(.*?)(?<!\\\\)\1');
        $this->defineToken('parenthesis_', '\(');
        $this->defineToken('_parenthesis', '\)');
        $this->defineToken('bracket_', '\[');
        $this->defineToken('_bracket', '\]');
        $this->defineToken('brace_', '{');
        $this->defineToken('_brace', '}');
        $this->defineToken('comma', ',');
        $this->defineToken('semicolon', ';');
        $this->defineToken('colon', ':');
        $this->defineToken('dot', '\.');
        $this->defineToken('backslash', '\\\\');
        $this->defineToken('dollar', '\$');
        $this->defineToken('equals', '=');
        $this->defineToken('plus', '\+');
        $this->defineToken('minus', '-');
        $this->defineToken('times', '\*');
        $this->defineToken('divide', '/');
        $this->defineToken('less_then', '<');
        $this->defineToken('greater_then', '>');
        $this->defineToken('identifier', '(?i)[a-zA-Z_][a-zA-Z0-9_]*');
    }
}
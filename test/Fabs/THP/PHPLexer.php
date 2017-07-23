<?php

namespace Fabs\THP;

use Fabs\Compiler\Lexer;
use Fabs\THP\Constant\Tokens;

class PHPLexer extends Lexer
{
    public function __construct()
    {
        $this->defineToken(Tokens::SPACE, '\s', true);
        $this->defineToken(Tokens::TRUE, '(?i)true');
        $this->defineToken(Tokens::FALSE, '(?i)true');
        $this->defineToken(Tokens::NULL, '(?i)null');
        $this->defineToken(Tokens::THP, '<\?php');
        $this->defineToken(Tokens::USING, '(?i)use');
        $this->defineToken(Tokens::COMMENT, '//(.*)', true);
        $this->defineToken(Tokens::STRING, '("|\')(.*?)(?<!\\\\)\1');
        $this->defineToken(Tokens::LEFT_PARENTHESIS, '\(');
        $this->defineToken(Tokens::RIGHT_PARENTHESIS, '\)');
        $this->defineToken(Tokens::LEFT_BRACKET, '\[');
        $this->defineToken(Tokens::RIGHT_BRACKET, '\]');
        $this->defineToken(Tokens::LEFT_BRACE, '{');
        $this->defineToken(Tokens::RIGHT_BRACE, '}');
        $this->defineToken(Tokens::COMMA, ',');
        $this->defineToken(Tokens::SEMICOLON, ';');
        $this->defineToken(Tokens::COLON, ':');
        $this->defineToken(Tokens::DOT, '\.');
        $this->defineToken(Tokens::BACKSLASH, '\\\\');
        $this->defineToken(Tokens::DOLLAR, '\$');
        $this->defineToken(Tokens::EQUALS, '=');
        $this->defineToken(Tokens::PLUS, '\+');
        $this->defineToken(Tokens::MINUS, '-');
        $this->defineToken(Tokens::TIMES, '\*');
        $this->defineToken(Tokens::DIVIDE, '/');
        $this->defineToken(Tokens::LESS_THEN, '<');
        $this->defineToken(Tokens::GREATER_THEN, '>');
        $this->defineToken(Tokens::IDENTIFIER, '(?i)[a-zA-Z_][a-zA-Z0-9_]*');
        $this->defineToken(Tokens::NOT, '(?i)not\b');
        $this->defineToken(Tokens::LOGICAL_OR, '(?i)or\b');
        $this->defineToken(Tokens::LOGICAL_AND, '(?i)and\b');
        $this->defineToken(Tokens::LOGICAL_XOR, '(?i)xor\b');
        $this->defineToken(Tokens::FLOAT, '\d+\.\d+');
        $this->defineToken(Tokens::INTEGER, '\d+');
    }
}
<?php

namespace Fabs\Compiler;

abstract class Parser
{
    /** @var Rule[] */
    protected $rule_list = [];

    /**
     * @param string $name
     * @return Rule
     */
    protected function addRule($name)
    {
        $rule = new Rule($name);
        $this->rule_list[] = $rule;
        return $rule;
    }

    public function parse($code)
    {
        $class = $this->getLexerClass();
        /** @var Lexer $lexer */
        $lexer = new $class();

        $tokens = $lexer->getTokens($code);
        return [$tokens, $this->rule_list];
    }

    public function getRuleList()
    {
        return $this->rule_list;
    }

    protected abstract function getLexerClass();
}
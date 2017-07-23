<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Value extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::VALUE);
        $this->startBlock();
        $this->matchToken(Tokens::NOT);
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->endBlock();
        $this->logicalOR();
        $this->takeToken(Tokens::TRUE);
        $this->logicalOR();
        $this->takeToken(Tokens::FALSE);
        $this->logicalOR();
        $this->takeToken(Tokens::NULL);
        $this->logicalOR();
        $this->takeToken(Tokens::FLOAT);
        $this->logicalOR();
        $this->takeToken(Tokens::INTEGER);
        $this->logicalOR();
        $this->takeToken(Tokens::STRING);
        $this->logicalOR();
        $this->callRule(Rules::ARRAY_DECLARATION);
        $this->logicalOR();
        $this->callRule(Rules::OBJECT_DECLARATION);
        $this->logicalOR();
        $this->callRule(Rules::CONSTANT);
        $this->logicalOR();
        $this->callRule(Rules::CHAIN);
        $this->logicalOR();
        $this->callRule(Rules::STRING_JOIN);
    }
}

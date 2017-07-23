<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class FunctionCall extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::FUNCTION_CALL);
        $this->setIsNode();
        $this->takeToken(Tokens::IDENTIFIER);
        $this->matchToken(Tokens::LEFT_PARENTHESIS);
        $this->startBlock(false, true);
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->startBlock(true, true);
        $this->matchToken(Tokens::COMMA);
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->endBlock();
        $this->endBlock();
        $this->matchToken(Tokens::RIGHT_PARENTHESIS);
    }
}
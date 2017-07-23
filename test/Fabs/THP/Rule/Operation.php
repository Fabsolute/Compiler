<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Operation extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::OPERATION);
        $this->callRule(Rules::OPERAND);
        $this->startBlock(false, true);
        $this->takeToken(Tokens::IDENTIFIER);
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->endBlock();
    }
}
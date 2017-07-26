<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Equality extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::EQUALITY);
        $this->setIsNode();
        $this->callRule(Rules::VARIABLE);
        $this->matchToken(Tokens::EQUALS);
        $this->startBlock();
        $this->callRule(Rules::STATIC_CLASS_ACCESS);
        $this->logicalOR();
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->endBlock();
    }
}
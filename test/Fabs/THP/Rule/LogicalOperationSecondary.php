<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class LogicalOperationSecondary extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::LOGICAL_OPERATION_SECONDARY);
        $this->callRule(Rules::OPERATION);
        $this->startBlock(false, true);
        $this->matchToken(Tokens::LOGICAL_AND);
        $this->callRule(Rules::LOGICAL_OPERATION_SECONDARY);
        $this->endBlock();
    }
}
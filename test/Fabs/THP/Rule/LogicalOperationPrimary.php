<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class LogicalOperationPrimary extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->callRule(Rules::LOGICAL_OPERATION_SECONDARY);

        $this->startBlock(false, true);

        $this->startBlock();

        $this->matchToken(Tokens::XXXXXXXXXX);
        $this->matchToken(Tokens::LOGICAL_OR);

        $this->logicalOR();

        $this->matchToken(Tokens::XXXXXXXXXX);
        $this->matchToken(Tokens::LOGICAL_XOR);
        $this->endBlock();

        $this->matchToken(Tokens::XXXXXXXXXX);
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->endBlock();
    }
}
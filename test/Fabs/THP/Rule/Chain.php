<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;

class Chain extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::CHAIN);
        $this->startBlock();
        $this->callRule(Rules::VARIABLE);
        $this->logicalOR();
        $this->callRule(Rules::FUNCTION_CALL);
        $this->endBlock();
        $this->startBlock(true, false);
        $this->callRule(Rules::ARRAY_ACCESS);
        $this->logicalOR();
        $this->callRule(Rules::OBJECT_ACCESS);
        $this->endBlock();

    }
}
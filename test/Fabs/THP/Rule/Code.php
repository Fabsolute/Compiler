<?php

namespace Fabs\THP\Rule;

use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;

class Code extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::CODE);
        $this->setIsNode();
        $this->callRule(Rules::COMMAND_OR_COMMENT);
        $this->startBlock(true, true);
        $this->callRule(Rules::COMMAND_OR_COMMENT);
        $this->endBlock();
    }
}
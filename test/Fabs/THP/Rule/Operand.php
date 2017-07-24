<?php

namespace Fabs\THP\Rule;

use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Operand extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::OPERAND);
        $this->matchToken(Tokens::LEFT_PARENTHESIS);
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
        $this->matchToken(Tokens::RIGHT_PARENTHESIS);
        $this->logicalOR();
        $this->callRule(Rules::VALUE);
    }
}
<?php

namespace Fabs\THP\Rule;

use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Command extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::COMMAND);
        $this->setIsNode();
        $this->startBlock();
        $this->callRule(Rules::USING);
        $this->logicalOR();
        $this->callRule(Rules::EQUALITY);
        $this->logicalOR();
        $this->callRule(Rules::STATIC_CLASS_ACCESS);
        $this->logicalOR();
        $this->callRule(Rules::EXPRESSION);
        $this->endBlock();
        $this->matchToken(Tokens::SEMICOLON);
    }
}

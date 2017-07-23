<?php

namespace Fabs\THP\Rule;

use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;

class CommandOrComment extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::COMMAND_OR_COMMENT);
        $this->callRule(Rules::COMMAND);
        $this->logicalOR();
        $this->callRule(Rules::COMMENT);
    }
}
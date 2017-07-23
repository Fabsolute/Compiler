<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;

class Expression extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::EXPRESSION);
        $this->setIsNode();
        $this->callRule(Rules::LOGICAL_OPERATION_PRIMARY);
    }
}
<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class ArrayAccess extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::ARRAY_ACCESS);
        $this->setIsNode();
        $this->matchToken(Tokens::LEFT_BRACKET);
        $this->callRule(Rules::VALUE);
        $this->matchToken(Tokens::RIGHT_BRACKET);
    }
}
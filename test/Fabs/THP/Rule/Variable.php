<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Variable extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::VARIABLE);
        $this->setIsNode();
        $this->matchToken(Tokens::DOLLAR);
        $this->takeToken(Tokens::IDENTIFIER);
    }
}
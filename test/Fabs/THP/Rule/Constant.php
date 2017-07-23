<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Constant extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::CONSTANT);
        $this->takeToken(Tokens::IDENTIFIER);
    }
}
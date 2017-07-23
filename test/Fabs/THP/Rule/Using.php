<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Using extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::USING);
        $this->setIsNode();
        $this->matchToken(Tokens::USING);
        $this->callRule(Rules::NAMESPACE_IDENTIFIER);
    }
}
<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class ObjectAccess extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::OBJECT_ACCESS);
        $this->matchToken(Tokens::MINUS);
        $this->matchToken(Tokens::LESS_THEN);
        $this->startBlock();
        $this->takeToken(Tokens::IDENTIFIER);
        $this->logicalOR();
        $this->callRule(Rules::FUNCTION_CALL);
        $this->endBlock();
    }
}
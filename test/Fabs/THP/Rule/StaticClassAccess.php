<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class StaticClassAccess extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::STATIC_CLASS_ACCESS);
        $this->setIsNode();
        $this->takeToken(Tokens::IDENTIFIER);
        $this->matchToken(Tokens::COLON);
        $this->matchToken(Tokens::COLON);
        $this->startBlock();
        $this->takeToken(Tokens::IDENTIFIER);
        $this->logicalOR();
        $this->callRule(Rules::FUNCTION_CALL);
        $this->endBlock();
    }
}
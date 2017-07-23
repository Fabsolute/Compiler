<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class ArrayDeclaration extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::ARRAY_DECLARATION);
        $this->setIsNode();
        $this->matchToken(Tokens::LEFT_BRACKET);
        $this->startBlock(false, true);
        $this->callRule(Rules::VALUE);
        $this->startBlock(true, true);
        $this->matchToken(Tokens::COMMA);
        $this->callRule(Rules::VALUE);
        $this->endBlock();
        $this->endBlock();
        $this->matchToken(Tokens::RIGHT_BRACKET);
    }
}
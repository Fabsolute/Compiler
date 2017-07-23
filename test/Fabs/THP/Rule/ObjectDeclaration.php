<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class ObjectDeclaration extends Rule
{

    public function __construct()
    {
        parent::__construct(Rules::OBJECT_DECLARATION);
        $this->setIsNode();
        $this->matchToken(Tokens::LEFT_BRACE);
        $this->startBlock(false, true);
        $this->callRule(Rules::OBJECT_PAIR);
        $this->startBlock(true, true);
        $this->matchToken(Tokens::COMMA);
        $this->callRule(Rules::OBJECT_PAIR);
        $this->endBlock();
        $this->endBlock();
        $this->matchToken(Tokens::RIGHT_BRACE);
    }
}
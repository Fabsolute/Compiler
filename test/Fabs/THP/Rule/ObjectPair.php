<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class ObjectPair extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::OBJECT_PAIR);
        $this->setIsNode();
        $this->startBlock();
        $this->callRule(Rules::VARIABLE);
        $this->logicalOR();
        $this->takeToken(Tokens::STRING);
        $this->endBlock();
        $this->matchToken(Tokens::COLON);
        $this->callRule(Rules::VALUE);
    }
}
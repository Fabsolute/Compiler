<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class StringJoin extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::STRING_JOIN);
        $this->setIsNode();
        $this->callRule(Rules::VALUE);
        $this->startBlock(true, true);
        $this->matchToken(Tokens::DOT);
        $this->callRule(Rules::VALUE);
        $this->endBlock();
    }
}
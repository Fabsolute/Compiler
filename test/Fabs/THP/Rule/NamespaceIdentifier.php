<?php


namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class NamespaceIdentifier extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::NAMESPACE_IDENTIFIER);
        $this->takeToken(Tokens::IDENTIFIER);
        $this->startBlock(true, true);
        $this->matchToken(Tokens::BACKSLASH);
        $this->takeToken(Tokens::IDENTIFIER);
        $this->endBlock();
    }
}
<?php

namespace Fabs\THP\Rule;

use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class Comment extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::COMMENT);
        $this->matchToken(Tokens::COMMENT);
    }
}
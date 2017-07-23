<?php
/**
 * Created by PhpStorm.
 * User: ahmetturk
 * Date: 23/07/2017
 * Time: 09:32
 */

namespace Fabs\THP\Rule;


use Fabs\Compiler\Rule;
use Fabs\THP\Constant\Rules;
use Fabs\THP\Constant\Tokens;

class THP extends Rule
{
    public function __construct()
    {
        parent::__construct(Rules::THP);

        $this->setIsNode();
        $this->matchToken(Tokens::THP);
        $this->callRule(Rules::CODE);
    }
}
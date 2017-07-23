<?php

namespace Fabs\Compiler;

class TokenDefinition
{
    /** @var string */
    public $name = null;
    /** @var string */
    public $regex = null;
    /** @var bool */
    public $should_ignore = false;
}
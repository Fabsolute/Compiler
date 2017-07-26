<?php

namespace Fabs\Compiler;

class Token
{
    /** @var string */
    public $name = null;
    /** @var string */
    public $value = null;

    public function __toString()
    {
        return $this->name;
    }
}
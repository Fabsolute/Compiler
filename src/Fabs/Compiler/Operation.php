<?php


namespace Fabs\Compiler;


class Operation
{
    /** @var string */
    public $type = null;
    /** @var string */
    public $value = null;
    /** @var bool */
    public $is_optional = false;
    /** @var bool */
    public $is_recursive = false;
}
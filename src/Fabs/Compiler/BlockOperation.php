<?php


namespace Fabs\Compiler;


class BlockOperation extends Operation
{
    /** @var bool */
    public $is_recursive = false;
    /** @var bool */
    public $is_optional = false;
    /** @var Operation[] */
    public $operation_list = [];
    /** @var BlockOperation */
    public $parent_operation = null;
}
<?php


namespace Fabs\Compiler;


class Node
{
    public $parent = null;
    /** @var Rule|Token */
    public $self = null;
    public $children = [];

    public function __toString()
    {
        if ($this->self instanceof Token) {
            $name = sprintf('token(%s, %s)', $this->self->name, $this->self->value);
        } else {
            $name = '#' . $this->self->getName();
        }

        static $i = 0;
        $out = str_repeat('>  ', $i) . $name . PHP_EOL;
        foreach ($this->children as $node) {

            ++$i;
            $out .= $node;
            --$i;
        }
        return $out;
    }
}
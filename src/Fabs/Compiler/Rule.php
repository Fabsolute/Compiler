<?php


namespace Fabs\Compiler;


class Rule
{
    /** @var string */
    protected $name = null;
    /** @var Operation[] */
    protected $operation_list = [];
    /** @var bool */
    protected $is_node = false;

    /**
     * Rule constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Rule
     */
    public function setNode()
    {
        $this->is_node = true;
        return $this;
    }

    public function startBlock($is_recursive = false, $is_optional = false)
    {
        $operation = new Operation();
        $operation->type = 'start_block';//todo
        $operation->is_optional = $is_optional;
        $operation->is_recursive = $is_recursive;
        $this->operation_list[] = $operation;
        return $this;
    }

    public function endBlock()
    {
        $operation = new Operation();
        $operation->type = 'start_block';//todo
        $this->operation_list[] = $operation;
        return $this;
    }

    public function or ()
    {
        $operation = new Operation();
        $operation->type = 'or';//todo
        $this->operation_list[] = $operation;
        return $this;
    }

    /**
     * @param string $token_name
     * @return Rule
     */
    public function matchToken($token_name)
    {
        $operation = new Operation();
        $operation->type = 'match_token';//todo
        $operation->value = $token_name;
        $this->operation_list[] = $operation;
        return $this;
    }

    /**
     * @param string $token_name
     * @return Rule
     */
    public function takeToken($token_name)
    {
        $operation = new Operation();
        $operation->type = 'take';//todo
        $operation->value = $token_name;
        $this->operation_list[] = $operation;
        return $this;
    }

    /**
     * @param string $rule_name
     * @param bool $is_recursive
     * @param bool $is_optional
     * @return Rule
     */
    public function callRule($rule_name, $is_recursive = false, $is_optional = false)
    {
        $operation = new Operation();
        $operation->type = 'call_rule';//todo
        $operation->value = $rule_name;
        $operation->is_optional = $is_optional;
        $operation->is_recursive = $is_recursive;
        $this->operation_list[] = $operation;
        return $this;
    }
}
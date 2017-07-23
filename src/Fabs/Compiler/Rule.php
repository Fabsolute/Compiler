<?php


namespace Fabs\Compiler;


use Fabs\Compiler\Constant\OperationTypes;

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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function getIsNode()
    {
        return $this->is_node;
    }

    /**
     * @return Operation[]
     */
    public function getOperationList()
    {
        return $this->operation_list;
    }

    /**
     * @param bool $is_node
     * @return Rule
     */
    public function setIsNode($is_node = true)
    {
        $this->is_node = $is_node;
        return $this;
    }

    public function startBlock($is_recursive = false, $is_optional = false)
    {
        $operation = new Operation();
        $operation->type = OperationTypes::START_BLOCK;
        $operation->is_optional = $is_optional;
        $operation->is_recursive = $is_recursive;
        $this->operation_list[] = $operation;
        return $this;
    }

    public function endBlock()
    {
        $operation = new Operation();
        $operation->type = OperationTypes::END_BLOCK;
        $this->operation_list[] = $operation;
        return $this;
    }

    public function logicalOR()
    {
        $operation = new Operation();
        $operation->type = OperationTypes::LOGICAL_OR;
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
        $operation->type = OperationTypes::MATCH_TOKEN;
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
        $operation->type = OperationTypes::TAKE_TOKEN;
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
        $operation->type = OperationTypes::CALL_RULE;
        $operation->value = $rule_name;
        $operation->is_optional = $is_optional;
        $operation->is_recursive = $is_recursive;
        $this->operation_list[] = $operation;
        return $this;
    }
}
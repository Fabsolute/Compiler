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
    /** @var BlockOperation */
    protected $current_block_operation = null;

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
        $operation = new BlockOperation();
        $operation->type = OperationTypes::BLOCK_OPERATION;
        $operation->is_optional = $is_optional;
        $operation->is_recursive = $is_recursive;

        if ($this->current_block_operation !== null) {
            $operation->parent_operation = $this->current_block_operation;
            $operation->parent_operation->operation_list[] = $operation;
        } else {
            $this->operation_list[] = $operation;
        }

        $this->current_block_operation = $operation;
        return $this;
    }

    public function endBlock()
    {
        if ($this->current_block_operation !== null) {
            if ($this->current_block_operation->parent_operation !== null) {
                $this->current_block_operation = $this->current_block_operation->parent_operation;
            } else {
                $this->current_block_operation = null;
            }
        }
        return $this;
    }

    public function logicalOR()
    {
        $operation = new Operation();
        $operation->type = OperationTypes::LOGICAL_OR;
        if ($this->current_block_operation === null) {
            $this->operation_list[] = $operation;
        } else {
            $this->current_block_operation->operation_list[] = $operation;
        }
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
        if ($this->current_block_operation === null) {
            $this->operation_list[] = $operation;
        } else {
            $this->current_block_operation->operation_list[] = $operation;
        }
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
        if ($this->current_block_operation === null) {
            $this->operation_list[] = $operation;
        } else {
            $this->current_block_operation->operation_list[] = $operation;
        }
        return $this;
    }

    /**
     * @param string $rule_name
     * @return Rule
     * @internal param bool $is_optional
     * @internal param bool $is_recursive
     */
    public function callRule($rule_name)
    {
        $operation = new Operation();
        $operation->type = OperationTypes::CALL_RULE;
        $operation->value = $rule_name;
        if ($this->current_block_operation === null) {
            $this->operation_list[] = $operation;
        } else {
            $this->current_block_operation->operation_list[] = $operation;
        }
        return $this;
    }
}
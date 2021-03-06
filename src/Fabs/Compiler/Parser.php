<?php

namespace Fabs\Compiler;

use Fabs\Compiler\Constant\OperationTypes;

abstract class Parser
{
    /** @var Rule[] */
    protected $rule_list = [];
    /** @var Token[] */
    protected $token_list = [];

    private $collected_tokens = [];

    private $current_point = 0;
    /** @var Node */
    private $tree = null;

    /**
     * @param string $code
     * @param Lexer $lexer
     * @return mixed
     * @throws \Exception
     */
    public function parse($code, $lexer)
    {
        if (count($this->rule_list) === 0) {
            throw new \Exception('any rule required');
        }

        $this->token_list = $lexer->getTokens($code);
        $first_rule = $this->rule_list[0];
//        echo '<pre>';
//        var_export($this->rule_list);
//        exit;

        $status = $this->execute($first_rule);
        if ($status) {
            return $this->buildTree();
        } else {
            return false;
        }
    }

    public function getRuleList()
    {
        return $this->rule_list;
    }

    /**
     * @param string|Rule $rule
     * @return Parser
     */
    public function addRule($rule)
    {
        if (is_string($rule)) {
            $rule = new $rule();
        }

        if ($rule instanceof Rule) {
            if (count($this->rule_list) === 0) {
                $this->rule_list[0] = $rule;
            }
            $this->rule_list[$rule->getName()] = $rule;
        }
        return $this;
    }

    /**
     * @param Rule $rule
     * @return string
     */
    private function execute($rule)
    {
        if ($this->current_point >= count($this->token_list)) {
            return false;
        }

//        static $REMOVE_counter = 0;

//        $REMOVE_counter++;

//
//        $REMOVE_counter--;
//
//
//        if ($response === true && $rule->getIsNode()) {
//            $REMOVE_out = str_repeat('│', $REMOVE_counter) . '├' . $rule->getName() . "\n";
//            echo $REMOVE_out . '<br>';
//        }

        $operation_list = $rule->getOperationList();
        $response = $this->safeCheckOperations($operation_list, $rule);
        return $response;
    }

    /**
     * @param $operation_list
     * @return bool
     */
    private function checkOperations($operation_list)
    {
        $split_operation_list = $this->splitOperations($operation_list);

        if (count($split_operation_list) !== 1) {
            foreach ($split_operation_list as $new_operation_list) {
                $response = $this->safeCheckOperations($new_operation_list);
                if ($response === true) {
                    return true;
                }
            }
            return false;
        }

        foreach ($operation_list as $operation) {
            switch ($operation->type) {
                case OperationTypes::MATCH_TOKEN:
                    $current_token = $this->getCurrentToken();
                    if ($current_token === null) {
                        return false;//todo wtf
                    }
                    if ($operation->value !== $current_token->name) {
                        return false;
                    }
                    $this->current_point++;
                    break;
                case OperationTypes::CALL_RULE:
                    $selected_rule = $this->rule_list[$operation->value];//todo rule not found
                    $response = $this->execute($selected_rule);
                    if ($response === false) {
                        return false;
                    }
                    break;
                case OperationTypes::TAKE_TOKEN:
                    $current_token = $this->getCurrentToken();
                    if ($current_token === false) {
                        return false;
                    }
                    if ($operation->value !== $current_token->name) {
                        return false;
                    }
                    $this->collected_tokens[] = ['type' => 'token', 'content' => $this->getCurrentToken()];
                    $this->current_point++;
                    //todo take token
                    break;
                case OperationTypes::BLOCK_OPERATION:
                    do {
                        /** @var BlockOperation $operation */
                        $response = $this->safeCheckOperations($operation->operation_list);
                    } while ($response !== false && $operation->is_recursive);

                    if ($response === false) {
                        if ($operation->is_optional !== true) {
                            return false;
                        }
                    }
                    break;
            }
        }

        return true;
    }

    /**
     * @param Operation[] $operation_list
     * @return Operation[][]
     */
    private function splitOperations($operation_list)
    {
        $split_operation_list = [];
        $current_split = [];
        foreach ($operation_list as $operation) {
            if ($operation->type === OperationTypes::LOGICAL_OR) {
                $split_operation_list[] = $current_split;
                $current_split = [];
            } else {
                $current_split[] = $operation;
            }
        }

        $split_operation_list[] = $current_split;
        return $split_operation_list;
    }

    /**
     * @param $operation_list
     * @param Rule $rule
     * @return bool
     */
    private function safeCheckOperations($operation_list, $rule = null)
    {
        $before_point = $this->current_point;
        $before_tree = $this->collected_tokens;

        if ($rule != null) {
            if ($rule->getIsNode() === true) {
                $this->collected_tokens[] = ['content' => $rule, 'type' => 'rule_start'];
            }
        }

        $response = $this->checkOperations($operation_list);

        if ($rule != null) {
            if ($rule->getIsNode() === true) {
                $this->collected_tokens[] = ['content' => $rule, 'type' => 'rule_end'];
            }
        }

        if ($response === false) {
            $this->current_point = $before_point;
            $this->collected_tokens = $before_tree;
        }

        return $response;
    }

    /**
     * @return Token
     */
    private function getCurrentToken()
    {
        if ($this->current_point >= count($this->token_list)) {
            return null;
        }
        return $this->token_list[$this->current_point];
    }

    private function buildTree()
    {
        $this->tree = new Node();
        /** @var Node $selected_node */
        $selected_node = null;

        foreach ($this->collected_tokens as $state) {
            if ($state['type'] === 'rule_start') {
                if ($selected_node !== null) {
                    $node = new Node();
                    $node->parent = $selected_node;
                    $selected_node->children[] = $node;
                } else {
                    $node = $this->tree;
                }

                $node->self = $state['content'];
                $selected_node = $node;
            } elseif ($state['type'] === 'rule_end') {
                $selected_node = $selected_node->parent;
            } elseif ($state['type'] === 'token') {
                $node = new Node();
                $node->self = $state['content'];
                $selected_node->children[] = $node;
            }
        }
        return $this->showTree();
    }


    public function showTree()
    {
        return (string)$this->tree;
    }
}

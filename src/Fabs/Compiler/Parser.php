<?php

namespace Fabs\Compiler;

use Fabs\Compiler\Constant\OperationTypes;

abstract class Parser
{
    /** @var Rule[] */
    protected $rule_list = [];

    private $current_point = 0;

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

        $token_list = $lexer->getTokens($code);
        $first_rule = $this->rule_list[0];

        return $this->execute($first_rule, $token_list);
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
     * @param Token[] $token_list
     * @return string
     * @internal param int $current_point
     */
    private function execute($rule, $token_list)
    {
        $operation_list = $rule->getOperationList();
        $response = $this->safeCheckOperations($operation_list, $token_list);
        var_dump('rule: ' . $rule->getName(), $response);
        return $response;
    }

    /**
     * @param $operation_list
     * @param Token[] $token_list
     * @return bool
     */
    private function checkOperations($operation_list, $token_list)
    {
        $split_operation_list = $this->splitOperations($operation_list);

        if (count($split_operation_list) !== 1) {

//            var_dump('split list', $split_operation_list,'split end');
            foreach ($split_operation_list as $new_operation_list) {
                $response = $this->safeCheckOperations($new_operation_list, $token_list);
                if ($response === true) {
                    return true;
                }
            }
            return false;
        }

        foreach ($operation_list as $operation) {
            switch ($operation->type) {
                case OperationTypes::MATCH_TOKEN:
                    if ($operation->value !== $token_list[$this->current_point]->name) {
                        return false;
                    }
                    echo 'token matched : ' . $operation->value . PHP_EOL;
                    $this->current_point++;
                    break;
                case OperationTypes::CALL_RULE:
                    $selected_rule = $this->rule_list[$operation->value];//todo rule not found
                    $response = $this->execute($selected_rule, $token_list);
                    if ($response === false) {
                        return false;
                    }
                    break;
                case OperationTypes::TAKE_TOKEN:
                    if ($operation->value !== $token_list[$this->current_point]->name) {
                        echo 'wtf! current_point: '
                            . $this->current_point
                            . ' expected: '
                            . $operation->value
                            . ' found '
                            . $token_list[$this->current_point]->name
                            . PHP_EOL;

                        return false;
                    }
                    echo 'token taked : ' . $operation->value . ' value: ' . $token_list[$this->current_point]->value . ' on current_point ' . $this->current_point . PHP_EOL;
                    $this->current_point++;
                    //todo take token
                    break;
                case OperationTypes::BLOCK_OPERATION:
                    /** @var BlockOperation $operation */
                    $response = $this->safeCheckOperations($operation->operation_list, $token_list);
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

    private function safeCheckOperations($operation_list, $token_list)
    {
        $before_point = $this->current_point;
        $response = $this->checkOperations($operation_list, $token_list);
        if ($response === false) {
            $this->current_point = $before_point;
        }

        return $response;
    }
}

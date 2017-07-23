<?php

namespace Fabs\Compiler;

use Fabs\Compiler\Constant\OperationTypes;

abstract class Parser
{
    /** @var Rule[] */
    protected $rule_list = [];

    /**
     * @param string $name
     * @return Rule
     */
    protected function defineRule($name)
    {
        $rule = new Rule($name);
        $this->addRule($rule);
        return $rule;
    }

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

        return $this->rule_list;

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
            $this->rule_list[] = $rule;
        }
        return $this;
    }

    /**
     * @param Rule $rule
     * @param Token[] $token_list
     * @param int $current_point
     * @return string
     */
    private function execute($rule, $token_list, $current_point = 0)
    {
        $name = $rule->getName();
        $token = $token_list[$current_point];

        foreach ($rule->getOperationList() as $operation) {
            switch ($operation->type) {
                case OperationTypes::MATCH_TOKEN:

                    break;
            }
        }

        return 'fuck';
    }
}

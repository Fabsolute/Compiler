<?php


namespace Fabs\Test;


use Fabs\Compiler\Parser;

class PHPParser extends Parser
{
    protected function getLexerClass()
    {
        return PHPLexer::class;
    }

    public function __construct()
    {
        $this->addRule('thp')
            ->setNode()
            ->matchToken('thp')
            ->callRule('code');

        $this->addRule('code')
            ->setNode()
            ->callRule('command_or_comment')
            ->callRule('command_or_comment', true, true);

        $this->addRule('command_or_comment')
            ->callRule('command')
            ->or()
            ->callRule('comment');

        $this->addRule('comment')
            ->matchToken('comment_char');

        $this->addRule('command')
            ->setNode()
            ->startBlock()
            ->callRule('use')
            ->or()
            ->callRule('equality')
            ->or()
            ->callRule('static_class_access')
            ->or()
            ->callRule('logical_operation_primary')
            ->endBlock()
            ->matchToken('semicolon');

        $this->addRule('static_class_access')
            ->setNode()
            ->takeToken('identifier')
            ->matchToken('colon')
            ->matchToken('colon')
            ->startBlock()
            ->takeToken('identifier')
            ->or()
            ->callRule('function_call')
            ->endBlock();

        $this->addRule('use')
            ->setNode()
            ->matchToken('use')
            ->callRule('namespace_identifier');

        $this->addRule('function_call')
            ->setNode()
            ->takeToken('identifier')
            ->matchToken('parenthesis_')
            ->startBlock(false, true)
            ->callRule('logical_operation_primary')
            ->startBlock(true, true)
            ->matchToken('comma')
            ->callRule('logical_operation_primary')
            ->endBlock()
            ->endBlock()
            ->matchToken('_parenthesis');

        $this->addRule('pair')
            ->setNode()
            ->startBlock()
            ->callRule('variable')
            ->or()
            ->takeToken('string')
            ->endBlock()
            ->matchToken('colon')
            ->callRule('value');

        $this->addRule('object_declaration')
            ->setNode()
            ->matchToken('brace_')
            ->startBlock(false, true)
            ->callRule('pair')
            ->startBlock(true, true)
            ->matchToken('comma')
            ->callRule('pair')
            ->endBlock()
            ->endBlock()
            ->matchToken('_brace');

        $this->addRule('array_declaration')
            ->setNode()
            ->matchToken('bracket_')
            ->startBlock(false, true)
            ->callRule('value')
            ->startBlock(true, true)
            ->matchToken('comma')
            ->callRule('value')
            ->endBlock()
            ->endBlock()
            ->matchToken('_bracket');

        $this->addRule('namespace_identifier')
            ->takeToken('identifier')
            ->startBlock(true, true)
            ->matchToken('backslash')
            ->takeToken('identifier')
            ->endBlock();

        $this->addRule('object_access')
            ->matchToken('minus')
            ->matchToken('less_then')
            ->startBlock()
            ->takeToken('identifier')
            ->or()
            ->callRule('function_call')
            ->endBlock();

        $this->addRule('string_join')
            ->setNode()
            ->callRule('value')
            ->startBlock(true, true)
            ->matchToken('dot')
            ->callRule('value')
            ->endBlock();

        $this->addRule('equality')
            ->setNode()
            ->callRule('variable')
            ->matchToken('equals')
            ->startBlock()
            ->callRule('static_class_access')
            ->or()
            ->callRule('expression')
            ->endBlock();

        $this->addRule('array_access')
            ->setNode()
            ->matchToken('bracket_')
            ->callRule('value')
            ->matchToken('_bracket');

        $this->addRule('variable')
            ->setNode()
            ->matchToken('dollar')
            ->takeToken('identifier');

        $this->addRule('constant')
            ->takeToken('identifier');

        $this->addRule('chain')
            ->startBlock()
            ->callRule('variable')
            ->or()
            ->callRule('function_call')
            ->endBlock()
            ->startBlock(true, false)
            ->callRule('array_access')
            ->or()
            ->callRule('object_access')
            ->endBlock();

        $this->addRule('value')
            ->startBlock()
            ->matchToken('not')
            ->callRule('logical_operation_primary')
            ->endBlock()
            ->or()
            ->takeToken('true')
            ->or()
            ->takeToken('false')
            ->or()
            ->takeToken('null')
            ->or()
            ->takeToken('float')
            ->or()
            ->takeToken('integer')
            ->or()
            ->takeToken('string')
            ->or()
            ->callRule('array_declaration')
            ->or()
            ->callRule('object_declaration')
            ->or()
            ->callRule('constant')
            ->or()
            ->callRule('chain')
            ->or()
            ->callRule('string_join');

        $this->addRule('operand')
            ->startBlock()
            ->matchToken('parenthesis_')
            ->callRule('logical_operation_primary')
            ->matchToken('_parenthesis')
            ->endBlock()
            ->or()
            ->callRule('value');

        $this->addRule('operation')
            ->callRule('operand')
            ->startBlock(false, true)
            ->takeToken('identifier')
            ->callRule('logical_operation_primary')
            ->endBlock();

        $this->addRule('logical_operation_secondary')
            ->callRule('operation')
            ->startBlock(false, true)
            ->matchToken('and')
            ->callRule('logical_operation_secondary')
            ->endBlock();

        $this->addRule('logical_operation_primary')
            ->callRule('logical_operation_secondary')
            ->startBlock(false, true)
            ->startBlock()
            ->matchToken('or')
            ->or()
            ->matchToken('xor')
            ->endBlock()
            ->callRule('logical_operation_primary')
            ->endBlock();

        $this->addRule('expression')
            ->setNode()
            ->callRule('logical_operation_primary');
    }
}
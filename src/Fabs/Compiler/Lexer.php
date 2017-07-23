<?php
/**
 * Created by PhpStorm.
 * User: fabsolutely
 * Date: 22/07/2017
 * Time: 21:19
 */

namespace Fabs\Compiler;

abstract class Lexer
{
    /** @var TokenDefinition[] */
    protected $token_definition_list = [];

    /**
     * @param string $name
     * @param string $regex
     * @param bool $should_ignore
     * @return Lexer
     */
    protected function defineToken($name, $regex, $should_ignore = false)
    {
        $token_definition = new TokenDefinition();
        $token_definition->name = $name;
        $token_definition->regex = $regex;
        $token_definition->should_ignore = $should_ignore;
        $this->token_definition_list[] = $token_definition;
        return $this;
    }

    /**
     * @param string $code
     * @return Token[]
     * @throws \Exception
     */
    public function getTokens($code)
    {
        $tokens = [];

        $current_point = 0;
        $end_point = strlen($code);

        while ($current_point < $end_point) {
            $token = $this->nextToken($code, $current_point);
            if ($token !== null) {
                if ($token->name !== '__ignore__this__token__') {
                    $tokens[] = $token;
                }
                $current_point += strlen($token->value);
            } else {
                throw new \Exception('token could not match');//todo
            }
        }

        return $tokens;
    }

    /**
     * @param string $code
     * @param int $current_point
     * @return Token|null
     */
    protected function nextToken($code, $current_point)
    {
        foreach ($this->token_definition_list as $token_definition) {
            $token = $this->matchToken($code, $token_definition->regex, $current_point);
            if ($token != null) {
                if ($token_definition->should_ignore === false) {
                    $token->name = $token_definition->name;
                } else {
                    $token->name = '__ignore__this__token__';
                }
                return $token;
            }
        }

        return null;
    }

    /**
     * @param string $code
     * @param string $regex
     * @param int $current_point
     * @return Token|null
     */
    protected function matchToken($code, $regex, $current_point)
    {
        $regex = '#\G(?|' . str_replace('#', '\#', $regex) . ')#';

        $match_count = preg_match($regex, $code, $matches, 0, $current_point);
        if ($match_count === 0) {
            return null;
        }

        $token = new Token();
        $token->value = $matches[0];
        return $token;
    }
}
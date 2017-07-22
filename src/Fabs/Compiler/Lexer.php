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
     * @return Lexer
     */
    protected function defineToken($name, $regex)
    {
        $token_definition = new TokenDefinition();
        $token_definition->name = $name;
        $token_definition->regex = $regex;
        $this->token_definition_list[] = $token_definition;
        return $this;
    }

    /**
     * @return Token[]
     */
    public function getTokens($code)
    {
        $tokens = [];

        $current_point = 0;
        $end_point = strlen($code);

        while ($current_point < $end_point) {
            $token = $this->nextToken($code, $current_point);
            if ($token !== null) {
                if ($token->name !== 'skip') { //todo
                    $tokens[] = $token;
                }
                $current_point += strlen($token->value);
            } else {
                die('wtf');
            }
        }

        return $tokens;
    }

    protected function nextToken($code, $offset)
    {
        foreach ($this->token_definition_list as $token_definition) {
            $token = $this->matchToken($code, $token_definition->regex, $offset);
            if ($token != null) {
                $token->name = $token_definition->name;
                return $token;
            }
        }

        return null;
    }

    /**
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
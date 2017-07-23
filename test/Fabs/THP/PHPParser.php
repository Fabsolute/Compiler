<?php


namespace Fabs\THP;


use Fabs\Compiler\Parser;
use Fabs\THP\Rule\ArrayAccess;
use Fabs\THP\Rule\ArrayDeclaration;
use Fabs\THP\Rule\Chain;
use Fabs\THP\Rule\Command;
use Fabs\THP\Rule\Constant;
use Fabs\THP\Rule\Equality;
use Fabs\THP\Rule\Expression;
use Fabs\THP\Rule\FunctionCall;
use Fabs\THP\Rule\LogicalOperationPrimary;
use Fabs\THP\Rule\LogicalOperationSecondary;
use Fabs\THP\Rule\NamespaceIdentifier;
use Fabs\THP\Rule\ObjectAccess;
use Fabs\THP\Rule\ObjectDeclaration;
use Fabs\THP\Rule\ObjectPair;
use Fabs\THP\Rule\Operand;
use Fabs\THP\Rule\Operation;
use Fabs\THP\Rule\StaticClassAccess;
use Fabs\THP\Rule\StringJoin;
use Fabs\THP\Rule\THP;
use Fabs\THP\Rule\Using;
use Fabs\THP\Rule\Value;
use Fabs\THP\Rule\Variable;

class PHPParser extends Parser
{
    public function __construct()
    {
        $this->addRule(THP::class);
        $this->addRule(Chain::class);
        $this->addRule(Using::class);
        $this->addRule(Value::class);
        $this->addRule(Operand::class);
        $this->addRule(Command::class);
        $this->addRule(Equality::class);
        $this->addRule(Constant::class);
        $this->addRule(Variable::class);
        $this->addRule(Operation::class);
        $this->addRule(StringJoin::class);
        $this->addRule(ObjectPair::class);
        $this->addRule(Expression::class);
        $this->addRule(ArrayAccess::class);
        $this->addRule(FunctionCall::class);
        $this->addRule(ObjectAccess::class);
        $this->addRule(ArrayDeclaration::class);
        $this->addRule(ObjectDeclaration::class);
        $this->addRule(StaticClassAccess::class);
        $this->addRule(NamespaceIdentifier::class);
        $this->addRule(LogicalOperationPrimary::class);
        $this->addRule(LogicalOperationSecondary::class);
    }
}
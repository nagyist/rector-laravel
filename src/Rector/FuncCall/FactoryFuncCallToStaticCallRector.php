<?php

declare(strict_types=1);

namespace RectorLaravel\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\StaticCall;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use RectorLaravel\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

/**
 * @changelog https://laravel.com/docs/7.x/database-testing#creating-models
 * @changelog https://laravel.com/docs/8.x/database-testing#instantiating-models
 *
 * @see \RectorLaravel\Tests\Rector\FuncCall\FactoryFuncCallToStaticCallRector\FactoryFuncCallToStaticCallRectorTest
 */
final class FactoryFuncCallToStaticCallRector extends AbstractRector implements ConfigurableRectorInterface
{
    private const string FACTORY = 'factory';

    /**
     * @var string[]
     */
    private array $allowList = [];

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Use the static factory method instead of global factory function.', [
            new CodeSample(
                <<<'CODE_SAMPLE'
factory(User::class);
CODE_SAMPLE

                ,
                <<<'CODE_SAMPLE'
User::factory();
CODE_SAMPLE
            ),
        ]);
    }

    public function configure(array $configuration): void
    {
        Assert::allString($configuration);
        $this->allowList = $configuration;
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [FuncCall::class];
    }

    /**
     * @param  FuncCall  $node
     */
    public function refactor(Node $node): ?Node
    {
        if (! $this->isName($node->name, self::FACTORY)) {
            return null;
        }

        if (! isset($node->args[0])) {
            return null;
        }

        if (! $node->args[0] instanceof Arg) {
            return null;
        }

        $firstArgValue = $node->args[0]->value;
        if (! $firstArgValue instanceof ClassConstFetch) {
            return null;
        }

        $model = $firstArgValue->class;

        if (! $this->isAllowedByAllowList($model)) {
            return null;
        }

        // create model
        if (! isset($node->args[1])) {
            return new StaticCall($model, self::FACTORY);
        }

        // create models of a given type
        return new StaticCall($model, self::FACTORY, [$node->args[1]]);
    }

    private function isAllowedByAllowList(Node $node): bool
    {
        return $this->allowList === [] || $this->isNames($node, $this->allowList);
    }
}

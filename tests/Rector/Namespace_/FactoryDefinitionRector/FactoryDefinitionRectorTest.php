<?php

declare(strict_types=1);

namespace RectorLaravel\Tests\Rector\Namespace_\FactoryDefinitionRector;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

final class FactoryDefinitionRectorTest extends AbstractRectorTestCase
{
    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixture/WithoutConfiguration');
    }

    /**
     * @test
     */
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/configured_rule_without_configuration.php';
    }
}

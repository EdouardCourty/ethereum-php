<?php

declare(strict_types=1);

namespace EthereumPHP\Tests\Utils;

use EthereumPHP\Utils\UuidGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \EthereumPHP\Utils\UuidGenerator
 *
 * @author Edouard Courty <edouard.courty2@gmail.com>
 */
class UuidGeneratorTest extends TestCase
{
    /**
     * @covers ::v4
     */
    public function testItGeneratesUuid(): void
    {
        $uuid = UuidGenerator::v4();

        $this->assertMatchesRegularExpression('/^[a-f0-9]{8}-[a-f0-9]{4}-4[a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/', $uuid);
    }
}

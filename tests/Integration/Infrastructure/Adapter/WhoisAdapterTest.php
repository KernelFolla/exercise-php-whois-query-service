<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Adapter;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Domain;
use App\Domain\ValueObject\DomainName;
use App\Infrastructure\Adapter\WhoisAdapter;

class WhoisAdapterTest extends TestCase
{
    public function testQueryReturnsWhoisData(): void
    {
        $adapter = new WhoisAdapter();
        $domain = new Domain(new DomainName('google.com'));

        $result = $adapter->query($domain);

        $this->assertArrayHasKey('raw_data', $result);
        $this->assertNotEmpty($result['raw_data']);
    }
}

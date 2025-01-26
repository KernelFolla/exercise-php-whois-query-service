<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Domain;
use App\Domain\ValueObject\DomainName;

class DomainTest extends TestCase
{
    public function testCreateValidDomain(): void
    {
        $domainName = new DomainName('example.com');
        $domain = new Domain($domainName);

        $this->assertEquals('example.com', $domain->getName()->getValue());
    }

    public function testSetAndGetWhoisData(): void
    {
        $domainName = new DomainName('example.com');
        $domain = new Domain($domainName);
        $whoisData = ['key' => 'value'];

        $domain->setWhoisData($whoisData);

        $this->assertEquals($whoisData, $domain->getWhoisData());
    }
}

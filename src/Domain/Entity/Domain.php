<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\DomainName;

/**
 * Class Domain
 *
 * Represents a domain entity with WHOIS data.
 */
class Domain
{
    /**
     * @var array The WHOIS data for the domain.
     */
    private array $whoisData;

    /**
     * Domain constructor.
     *
     * @param DomainName $name The domain name value object.
     */
    public function __construct(
        private DomainName $name
)
    {
    }

    /**
     * Get the domain name.
     *
     * @return DomainName The domain name value object.
     */
    public function getName(): DomainName
    {
        return $this->name;
    }

    /**
     * Set the WHOIS data for the domain.
     *
     * @param array $data The WHOIS data.
     */
    public function setWhoisData(array $data): void
    {
        $this->whoisData = $data;
    }

    /**
     * Get the WHOIS data for the domain.
     *
     * @return array The WHOIS data.
     */
    public function getWhoisData(): array
    {
        return $this->whoisData;
    }
}
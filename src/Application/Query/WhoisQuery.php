<?php

declare(strict_types=1);

namespace App\Application\Query;

/**
 * Class WhoisQuery
 *
 * Represents a query for WHOIS information of a domain.
 */
class WhoisQuery
{
    /**
     * WhoisQuery constructor.
     *
     * @param string $domainName The domain name to query.
     */
    public function __construct(
        private readonly string $domainName
    ){}

    /**
     * Get the domain name.
     *
     * @return string The domain name.
     */
    public function getDomainName(): string
    {
        return $this->domainName;
    }
}
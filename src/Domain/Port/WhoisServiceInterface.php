<?php

declare(strict_types=1);

namespace App\Domain\Port;

use App\Domain\Entity\Domain;

/**
 * Interface WhoisServiceInterface
 *
 * Defines the contract for a service that performs WHOIS queries.
 */
interface WhoisServiceInterface
{
    /**
     * Queries WHOIS information for a given domain.
     *
     * @param Domain $domain The domain entity containing the domain name.
     * @return array The structured WHOIS information.
     */
    public function query(Domain $domain): array;
}
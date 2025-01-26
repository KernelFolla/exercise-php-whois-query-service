<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\Domain;
use App\Domain\ValueObject\DomainName;
use App\Domain\Port\WhoisServiceInterface;
use App\Application\Query\WhoisQuery;

/**
 * Class WhoisService
 *
 * This service handles the execution of WHOIS queries.
 */
class WhoisService
{


    /**
     * WhoisService constructor.
     *
     * @param WhoisServiceInterface $whoisAdapter The WHOIS service adapter.
     */
    public function __construct(
        private readonly WhoisServiceInterface $whoisAdapter
    )
    {}

    /**
     * Executes a WHOIS query.
     *
     * @param WhoisQuery $query The WHOIS query.
     * @return array The structured WHOIS information.
     */
    public function execute(WhoisQuery $query): array
    {
        $domain = new Domain(new DomainName($query->getDomainName()));
        return $this->whoisAdapter->query($domain);
    }
}
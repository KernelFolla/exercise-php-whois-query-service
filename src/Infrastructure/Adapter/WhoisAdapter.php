<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Domain\Entity\Domain;
use App\Domain\Port\WhoisServiceInterface;

/**
 * WHOIS Service Adapter Implementation
 *
 * This class provides WHOIS lookup functionality for domain names
 * by connecting to the WHOIS server.
 */
readonly class WhoisAdapter implements WhoisServiceInterface
{
    public function __construct(
        private string $whoisServer = "whois.verisign-grs.com",
        private int    $whoisPort = 43,
        private int    $timeout = 10
    ) {}

    /**
     * Performs a WHOIS query for the given domain
     *
     * @param Domain $domain The domain entity to query
     * @return array Structured WHOIS information
     * @throws \RuntimeException When connection fails or response parsing fails
     */
    public function query(Domain $domain): array
    {
        $domainName = $domain->getName()->getValue();

        try {
            $socket = $this->connect();
            $response = $this->sendQuery($socket, $domainName);
            $parsedData = $this->parseResponse($response);

            return $parsedData;
        } catch (\Exception $e) {
            throw new \RuntimeException(
                "WHOIS query failed: " . $e->getMessage(),
                0,
                $e
            );
        }
    }

    /**
     * Establishes connection to the WHOIS server
     *
     * @return resource
     * @throws \RuntimeException
     */
    private function connect()
    {
        $errno = 0;
        $errstr = '';

        $socket = @fsockopen(
            $this->whoisServer,
            $this->whoisPort,
            $errno,
            $errstr,
            $this->timeout
        );

        if (!$socket) {
            throw new \RuntimeException(
                "Failed to connect to WHOIS server: {$errstr} ({$errno})"
            );
        }

        stream_set_timeout($socket, $this->timeout);
        return $socket;
    }

    /**
     * Sends a WHOIS query and receives the response
     *
     * @param resource $socket
     * @param string $domainName
     * @return string
     * @throws \RuntimeException
     */
    private function sendQuery($socket, string $domainName): string
    {
        if (fwrite($socket, $domainName . "\r\n") === false) {
            throw new \RuntimeException("Failed to send WHOIS query");
        }

        $response = '';
        while (!feof($socket)) {
            $buffer = fgets($socket, 1024);
            if ($buffer === false) {
                throw new \RuntimeException("Failed to read from socket");
            }
            $response .= $buffer;
        }

        fclose($socket);
        return $response;
    }

    /**
     * Parses the raw WHOIS response into a structured array
     *
     * @param string $response
     * @return array
     */
    private function parseResponse(string $response): array
    {
        $parsed = [
            'raw_data' => $response,
            'domain_status' => [],
            'name_servers' => [],
            'dates' => [],
            'registrar' => '',
        ];

        // Extract domain status
        if (preg_match_all('/Status: (.+)$/m', $response, $matches)) {
            $parsed['domain_status'] = $matches[1];
        }

        // Extract nameservers
        if (preg_match_all('/Name Server: (.+)$/m', $response, $matches)) {
            $parsed['name_servers'] = $matches[1];
        }

        // Extract important dates
        if (preg_match('/Creation Date: (.+)$/m', $response, $match)) {
            $parsed['dates']['created'] = trim($match[1]);
        }
        if (preg_match('/Registry Expiry Date: (.+)$/m', $response, $match)) {
            $parsed['dates']['expires'] = trim($match[1]);
        }

        // Extract registrar
        if (preg_match('/Registrar: (.+)$/m', $response, $match)) {
            $parsed['registrar'] = trim($match[1]);
        }

        return $parsed;
    }
}

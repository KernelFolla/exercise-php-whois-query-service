<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

/**
 * Class DomainName
 *
 * Represents a domain name value object.
 */
class DomainName
{
    /**
     * @var string The domain name value.
     */
    private string $value;

    /**
     * DomainName constructor.
     *
     * @param string $value The domain name value.
     * @throws \InvalidArgumentException if the domain name format is invalid or not a .com domain.
     */
    public function __construct(string $value)
    {
        if (!$this->isValid($value)) {
            throw new \InvalidArgumentException('Invalid domain name format');
        }
        if (!$this->isComDomain($value)) {
            throw new \InvalidArgumentException('Only .com domains are supported');
        }
        $this->value = $value;
    }

    /**
     * Validates the domain name format.
     *
     * @param string $domain The domain name to validate.
     * @return bool True if the domain name format is valid, false otherwise.
     */
    private function isValid(string $domain): bool
    {
        return (bool) filter_var($domain, FILTER_VALIDATE_DOMAIN);
    }

    /**
     * Checks if the domain name is a .com domain.
     *
     * @param string $domain The domain name to check.
     * @return bool True if the domain name is a .com domain, false otherwise.
     */
    private function isComDomain(string $domain): bool
    {
        return str_ends_with($domain, '.com');
    }

    /**
     * Gets the domain name value.
     *
     * @return string The domain name value.
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
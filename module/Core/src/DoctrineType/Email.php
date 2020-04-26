<?php

declare(strict_types=1);

namespace Core\DoctrineType;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

/**
 * Class Email
 * @package User\Entity
 */
class Email
{
    use ValueTrait;

    /**
     * Email constructor.
     *
     * @param string $value
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid mail.');
        }
        $this->value = mb_strtolower($value);
    }

    /**
     * @param Email $other
     *
     * @return bool
     */
    public function isEqual(Email $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}

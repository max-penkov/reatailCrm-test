<?php

declare(strict_types=1);

namespace Core\DoctrineType;

/**
 * Trait ValueTrait
 * @package Core\DoctrineType
 */
trait ValueTrait
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getValue();
    }
}

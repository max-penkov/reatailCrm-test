<?php

declare(strict_types=1);

namespace Core\Interfaces;

/**
 * Interface HistorizableInterface
 * @package Core\Interfaces
 */
interface HistorizableInterface
{
    /**
     * @return string
     */
    public function getHistoryClass(): string;

    public function getHistories();
}
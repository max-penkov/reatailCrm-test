<?php

declare(strict_types=1);

namespace Application\Services;

use Core\Entity\History;
use DateTime;

/**
 * Class Item
 * @package Application\Services
 */
class Item
{
    private $date;

    /** @var History */
    private $history;

    private function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    public static function forHistory(DateTime $date, History $model): self
    {
        $item          = new self($date);
        $item->history = $model;

        return $item;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getHistory()
    {
        return $this->history;
    }
}

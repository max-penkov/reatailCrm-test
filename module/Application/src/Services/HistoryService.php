<?php

declare(strict_types=1);

namespace Application\Services;

use Core\Entity\History;

/**
 * Class HistoryService
 * @package Application\Services
 */
class HistoryService
{
    /**
     * @param History ...$models
     *
     * @return array
     */
    public function getAll(History ...$models)
    {
        $items = [];
        foreach ($models as $model) {
            $items[] = Item::forHistory($model->getPerformedAt(), $model);
        }

        usort($items, static function (Item $a, Item $b) {
            return $a->getDate() <=> $b->getDate();
        });

        return $items;
    }
}

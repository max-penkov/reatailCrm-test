<?php

declare(strict_types=1);

namespace Core\Event\Dispatcher;

/**
 * Class EventDispatcher
 * @package App\Event\Dispatcher
 */
interface EventDispatcher
{
    public function dispatch(...$events): void;
}

<?php

declare(strict_types=1);

namespace Application\Services;

use Exception;
use Psr\Log\LoggerInterface;

/**
 * Class ErrorHandler
 * @package Application\Services
 */
class ErrorHandler
{
    private $logger;

    /**
     * ErrorHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Exception $e
     */
    public function handle(Exception $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}

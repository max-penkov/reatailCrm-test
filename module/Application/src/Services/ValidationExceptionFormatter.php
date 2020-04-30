<?php

declare(strict_types=1);

namespace Application\Services;

use Apllication\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ValidationExceptionFormatter
 * @package Application\Services
 */
class ValidationExceptionFormatter implements EventSubscriberInterface
{
    /**
     * @var ErrorHandler
     */
    private $errors;

    /**
     * ValidationExceptionFormatter constructor.
     *
     * @param ErrorHandler $errors
     */
    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        /** @var ValidationException $exception */
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        if ($exception instanceof ValidationException) {
            if (strpos($request->attributes->get('_route'), 'api.') !== 0) {
                return;
            }

            $this->errors->handle($exception);

            $event->setResponse(new JsonResponse([
                'errors' => $exception->getErrors()->toArray(),
            ], Response::HTTP_BAD_REQUEST));
        } else {
            return;
        }
    }
}

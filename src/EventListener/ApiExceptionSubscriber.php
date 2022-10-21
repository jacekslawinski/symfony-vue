<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ApiExceptionSubscriber implements EventSubscriberInterface
{

    /**
     *
     * @param ExceptionEvent $eventException
     */
    public function onKernelException(ExceptionEvent $eventException)
    {
        $event = $eventException->getThrowable();
        if (!$event instanceof ValidationException) {
            return;
        }
        $response = new JsonResponse($event->getErrors(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->headers->set('Content-Type', 'application/json');
        $eventException->setResponse($response);
    }

    /**
     *
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}

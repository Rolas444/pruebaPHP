<?php
namespace Application\EventListener;

use Domain\User\Event\UserRegisteredEvent;
use Psr\Log\LoggerInterface;

class UserEventListener {
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    public function onUserRegistered(UserRegisteredEvent $event): void {
        $user = $event->getUser();
        // Acción simulada: enviar un email de bienvenida
        $this->logger->info('Sending welcome email to ' . $user->getEmail());
        
    }
}

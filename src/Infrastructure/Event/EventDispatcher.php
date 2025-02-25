<?php

namespace Infrastructure\Event;

class EventDispatcher {
    private array $listeners = [];

    public function addListener(string $eventName, callable $listener): void {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(object $event): void {
        $eventName = get_class($event);
        if (!empty($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                $listener($event);
            }
        }
    }
}
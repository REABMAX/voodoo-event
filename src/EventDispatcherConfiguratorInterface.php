<?php

namespace Voodoo\Event;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Interface EventDispatcherConfiguratorInterface
 * @package Voodoo\Event
 */
interface EventDispatcherConfiguratorInterface
{
    /**
     * @param array $eventConfig
     * @return mixed
     */
    public function __invoke(array $eventConfig);

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher(): EventDispatcherInterface;

    /**
     * @return ListenerProviderInterface
     */
    public function getListenerProvider(): ListenerProviderInterface;
}
<?php

namespace Voodoo\Event\Configurators;

use Phly\EventDispatcher\EventDispatcher;
use Phly\EventDispatcher\LazyListener;
use Phly\EventDispatcher\ListenerProvider\AttachableListenerProviderInterface;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Voodoo\Event\EventDispatcherConfiguratorInterface;

/**
 * Class PhlyEventDispatcherConfigurator
 * @package Voodoo\Event\Configurators
 */
class PhlyEventDispatcherConfigurator implements EventDispatcherConfiguratorInterface
{
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var ListenerProviderInterface
     */
    protected $listenerProvider;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * PhlyEventDispatcherConfigurator constructor.
     * @param EventDispatcher $eventDispatcher
     * @param AttachableListenerProviderInterface $listenerProvider
     * @param ContainerInterface $container
     */
    public function __construct(EventDispatcher $eventDispatcher, AttachableListenerProviderInterface $listenerProvider, ContainerInterface $container)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->listenerProvider = $listenerProvider;
        $this->container = $container;
    }

    /**
     * @param array $eventConfig
     * @return mixed|void
     */
    public function __invoke(array $eventConfig)
    {
        foreach ($eventConfig as $event => $listeners) {
            foreach ($listeners as $listener) {
                if (!is_callable($listener) && is_string($listener)) {
                    $listener = new LazyListener($this->container, $listener);
                }

                $this->listenerProvider->listen($event, $listener);
            }
        }
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    /**
     * @return ListenerProviderInterface
     */
    public function getListenerProvider(): ListenerProviderInterface
    {
        return $this->listenerProvider;
    }
}
<?php

namespace App\Actions;

use Illuminate\Contracts\Container\Container;

class ActionBus
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var array
     */
    private $handlers;

    public function __construct(Container $container, array $handlers)
    {
        $this->container = $container;
        $this->handlers = $handlers;
    }

    public function trigger($action)
    {
        $handlerClassName = $this->handlers[get_class($action)];

        $actionHandlerInstance = $this->container->make($handlerClassName);

        return $actionHandlerInstance->handle();
    }
}

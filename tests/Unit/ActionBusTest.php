<?php

namespace Tests\Unit;

use App\Actions\ActionBus;
use Illuminate\Contracts\Container\Container;
use Mockery;
use Tests\TestCase;

class ActionBusTest extends TestCase
{
    /** @test */
    function it_triggers_the_proper_action()
    {
        // Let's make use of a Dummy
        $handlerInstance = (new class {
            public function handle()
            {
                return 'dummyOperation';
            }
        });

        $dummyAction = (new class {
        });

        $handlersList = [
            get_class($dummyAction) => 'dummyHandlerInstance'
        ];

        $container = Mockery::mock(Container::class);

        $container->shouldReceive('make')
                  ->with('dummyHandlerInstance')
                  ->once()
                  ->andReturn($handlerInstance);

        $actionBus = new ActionBus($container, $handlersList);

        $outcome = $actionBus->trigger($dummyAction);

        $this->assertEquals('dummyOperation', $outcome);
    }
}

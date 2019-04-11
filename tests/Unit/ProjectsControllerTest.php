<?php

namespace Tests\Unit;

use App\Actions\ActionBus;
use App\Actions\AddProjectAction;
use App\Http\Controllers\CoolProjectsController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class ProjectsControllerTest extends TestCase
{
    /** @test */
    function it_stores_a_new_project()
    {
        $guard = Mockery::mock(Guard::class);
        $guard->shouldReceive('id')->once()->andReturn(101);

        $projectResource = [
            'data' => [
                'name' => 'dummy',
                'client_id' => 101
            ]
        ];

        $actionBus = Mockery::mock(ActionBus::class);
        $actionBus->shouldReceive('trigger')
                  ->once()
                  ->with(Mockery::on(function (AddProjectAction $action) {
                      return $action->getName() === 'dummy'
                          && $action->getClientId() === 101;
                  }))->andReturn($projectResource);

        $responseFactory = Mockery::mock(ResponseFactory::class);
        $responseFactory->shouldReceive('json')
                        ->once()
                        ->with($projectResource, 201)
                        ->andReturn($projectResource);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('get')
                ->with('name')
                ->andReturn('dummy');

        $projectsController = new CoolProjectsController($guard, $actionBus, $responseFactory);
        $response = $projectsController->store($request);

        $this->assertEquals($response, $projectResource);
    }
}

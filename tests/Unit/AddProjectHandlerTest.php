<?php

namespace Tests\Unit;

use App\Actions\ActionHandlers\AddProjectActionHandler;
use App\Actions\AddProjectAction;
use App\Http\Resources\ProjectResource;
use App\Repositories\ProjectRepository;
use Mockery;
use Tests\TestCase;

class AddProjectHandlerTest extends TestCase
{
    /** @test */
    function it_can_handle_the_action()
    {
        $projectRepo = Mockery::mock(ProjectRepository::class);

        $projectRepo->shouldReceive('add')
                    ->with(Mockery::on(function ($product) {
                          return $product->name === 'dummy'
                              && $product->client_id === 101;
                    }))
                    ->once()
                    ->andReturnTrue();

        $addProjectAction = Mockery::mock(AddProjectAction::class);

        $addProjectAction->shouldReceive([
            'getName' => 'dummy',
            'getClientId' => 101
        ])->once();

        $handler = new AddProjectActionHandler($projectRepo);

        $project = $handler->handle($addProjectAction);

        $this->assertInstanceOf(ProjectResource::class, $project);

        $this->assertEquals('dummy', $project->resource->name);
        $this->assertEquals(101, $project->resource->client_id);
    }
}

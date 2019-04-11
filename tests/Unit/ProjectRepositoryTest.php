<?php

namespace Tests\Unit;

use App\Project;
use App\Repositories\ProjectRepository;
use Mockery;
use Tests\TestCase;

class ProjectRepositoryTest extends TestCase
{
    /** @test */
    function it_returns_true_if_it_adds_a_project()
    {
        $dbGateway = Mockery::mock(Project::class);

        $dbGateway->shouldReceive('save')->andReturnTrue();

        $projectRepository = new ProjectRepository;

        $this->assertTrue($projectRepository->add($dbGateway));
    }

    /** @test */
    function it_returns_false_if_it_could_not_add_a_project()
    {
        $dbGateway = Mockery::mock(Project::class);

        $dbGateway->shouldReceive('save')->andReturnFalse();

        $projectRepository = new ProjectRepository;

        $this->assertFalse($projectRepository->add($dbGateway));
    }
}

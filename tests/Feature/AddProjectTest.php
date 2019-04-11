<?php

namespace Tests\Feature;

use App\Client;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddProjectTest extends TestCase
{
    use RefreshDatabase;

    private $endpoint = 'api/cool/projects';

    /** @test */
    function a_client_can_add_a_project()
    {
        $this->withoutExceptionHandling();
        $client = factory(Client::class)->create();

        $project = factory(Project::class)->make(['client_id' => $client->id]);

        $this->actingAs($client);

        $response = $this->post($this->endpoint, [
            'name' => $project->name,
        ]);

        $this->assertDatabaseHas('projects', $project->toArray());

        $response->assertStatus(201);

        $response->assertJson([
            'data' => [
                'name' => $project->name,
                'client_id' => $client->id
            ]
        ]);
    }

    /** @test */
    function a_guest_cannot_add_a_project()
    {
        $project = factory(Project::class)->make();

        $response = $this->post($this->endpoint, [
            'name' => 'dummyProject',
        ]);

        $this->assertDatabaseMissing('projects', $project->toArray());

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }
}

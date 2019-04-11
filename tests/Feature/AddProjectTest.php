<?php

namespace Tests\Feature;

use App\Client;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_client_can_add_a_project()
    {
        $this->withoutExceptionHandling();
        $client = factory(Client::class)->create();

        $project = factory(Project::class)->make(['client_id' => $client->id]);

        $this->actingAs($client);

        $response = $this->post('api/projects', [
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

        $response = $this->post('api/projects', [
            'name' => 'dummyProject',
        ]);

        $this->assertDatabaseMissing('projects', $project->toArray());

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    /** @test */
    function a_client_cannot_add_a_project_with_the_name_that_is_already_taken()
    {
        $client = factory(Client::class)->create();

        $existingProject = factory(Project::class)->create(['client_id' => $client->id]);

        $this->actingAs($client);

        $response = $this->post('api/projects', [
            'name' => $existingProject->name
        ]);

        $numberOfProjectsFromDBWithThatName = Project::where('name', $existingProject->name)->count();
        $this->assertEquals(1, $numberOfProjectsFromDBWithThatName);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => [
                    'The name has already been taken.'
                ]
            ]
        ]);
    }
}

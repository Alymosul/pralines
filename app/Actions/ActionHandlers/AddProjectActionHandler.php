<?php

namespace App\Actions\ActionHandlers;

use App\Actions\AddProjectAction;
use App\Http\Resources\ProjectResource;
use App\Project;
use App\Repositories\ProjectRepository;
use \RuntimeException;

class AddProjectActionHandler
{
    /**
     * @var ProjectRepository
     */
    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddProjectAction $action)
    {
        $project = new Project([
            'name' => $action->getName(),
            'client_id' => $action->getClientId()
        ]);

        if (!$this->repository->add($project)) {
            throw new RuntimeException('Could not add new project.');
        }

        return new ProjectResource($project);
    }
}

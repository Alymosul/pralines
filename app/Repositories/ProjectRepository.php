<?php

namespace App\Repositories;

use App\Project;

class ProjectRepository
{
    public function add(Project $project): bool
    {
        return $project->save();
    }
}

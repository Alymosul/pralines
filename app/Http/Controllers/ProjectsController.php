<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProjectsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|min:2',
        ]);

        $clientId = Auth::id();

        $project = Project::create([
            'name' => $request->get('name'),
            'client_id' => $clientId
        ]);

        return Response::json([
            'data' => [
                'name' => $project->name,
                'client_id' => $project->client_id
            ]
        ], 201);
    }
}

<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class ProjectsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'min:2',
                Rule::unique('projects')->where('client_id', Auth::id())
            ]
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

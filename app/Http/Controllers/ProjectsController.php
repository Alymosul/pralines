<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class ProjectsController extends Controller
{
    public function store(Request $request)
    {
        $clientId = Auth::id();

        $this->validate($request, [
            'name' => [
                'required',
                'string',
                'min:2',
                Rule::unique('projects')->where('client_id', $clientId)
            ]
        ]);

        $project = Project::create([
            'name' => $request->get('name'),
            'client_id' => $clientId
        ]);

        $data = new ProjectResource($project);

        return Response::json($data, 201);
    }
}

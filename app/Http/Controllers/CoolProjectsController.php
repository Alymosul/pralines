<?php

namespace App\Http\Controllers;

use App\Actions\ActionBus;
use App\Actions\AddProjectAction;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class CoolProjectsController extends Controller
{
    private $authGuard;

    private $actionBus;

    private $response;

    public function __construct(Guard $authGuard, ActionBus $actionBus, ResponseFactory $response)
    {
        $this->authGuard = $authGuard;
        $this->actionBus = $actionBus;
        $this->response = $response;
    }

    public function store(Request $request)
    {
        $action = new AddProjectAction($request->get('name'), $this->authGuard->id());

        $result = $this->actionBus->trigger($action);

        return $this->response->json();
    }
}

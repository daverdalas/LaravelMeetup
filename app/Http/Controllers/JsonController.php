<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Transformers\UserTransformer;
use App\User;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class JsonController extends Controller
{
    /**
     * @var Manager
     */
    private $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function badIndex()
    {
        $users = User::all();

        return response()->json(['user' => $users]);
    }

    public function goodIndex()
    {
        $users = User::all();

        $resource = new Collection($users, new UserTransformer());
        $rootScope = $this->manager->createData($resource);
        return response()->json($rootScope->toArray());
    }

    public function goodIndexResources()
    {
        $users = User::all();

        return UserResource::collection($users);
    }
}

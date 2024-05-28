<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetUserRequest $request)
    {
        $users = User::with("roles")->whereHas("roles", function ($query) {
            $query->where("name", "moderator");
        });
    
        if ($keyword = $request->search) {
            $users->where(function ($query) use ($keyword) {
                $query->where("email", "like", "%$keyword%")
                      ->orWhere("name", "like", "%$keyword%");
            });
        }
    
        $users->orderBy($request->input("order", "name"), 
        $request->input("direction", "asc"));
    
        $users = $users->get(); 
    
        if ($users->isEmpty()) {
            throw new NotFoundHttpException("Users not found");
        }
    
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage./
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->assignRole("moderator");
        $user->roles = $user->roles()->get();

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with("roles")->findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->roles = $user->roles()->get();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(["message" => "Moderator successfully deleted"]);
    }
}

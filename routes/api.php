<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BossController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\FactionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('/users/signup', [UserController::class, "store"]);
        $api->post('/users/login', [AuthController::class, "login"]);

        $api->group(['middleware' => 'jwt.auth'], function ($api) {
            $api->post('/token/refresh', [AuthController::class, "refresh"]);
            $api->post('/logout', [AuthController::class, "logout"]);
            $api->get('/me', [AuthController::class, "me"]);
        });
    });

    $api->group(["prefix" => "bosses"], function ($api) {

        $api->group(["middleware" => ["role:moderator|admin"]], function ($api) {
            $api->post("/", [BossController::class, "store"]);
            $api->post("/{id}", [BossController::class, "update"]);
            $api->delete("/{id}", [BossController::class, "destroy"]);
        });

        $api->group(["middleware" => ["permission:view boss"]], function ($api) {
            $api->get("/", [BossController::class, "index"]);
            $api->get("/{id}", [BossController::class, "show"]);
        });
    });

    $api->group(["prefix" => "factions"], function ($api) {

        $api->group(["middleware" => ["role:moderator|admin"]], function ($api) {
            $api->post("/", [FactionController::class, "store"]);
            $api->post("/{id}", [FactionController::class, "update"]);
            $api->delete("/{id}", [FactionController::class, "destroy"]);
        });

        $api->group(["middleware" => ["permission:view faction"]], function ($api) {
            $api->get("/", [FactionController::class, "index"]);
            $api->get("/{id}", [FactionController::class, "show"]);
        });
    });

    $api->group(["prefix" => "classes"], function ($api) {

        $api->group(["middleware" => ["role:moderator|admin"]], function ($api) {
            $api->post("/", [ClassController::class, "store"]);
            $api->post("/{id}", [ClassController::class, "update"]);
            $api->delete("/{id}", [ClassController::class, "destroy"]);
        });

        $api->get("/", [ClassController::class, "index"]);
        $api->get("/{id}", [ClassController::class, "show"]);
    });

    $api->group(["prefix" => "locations"], function ($api) {

        $api->group(["middleware" => ["role:moderator|admin"]], function ($api) {
            $api->post("/", [LocationController::class, "store"]);
            $api->post("/{id}", [LocationController::class, "update"]);
            $api->delete("/{id}", [LocationController::class, "destroy"]);
        });

        $api->get("/", [LocationController::class, "index"]);
        $api->get("/{id}", [LocationController::class, "show"]);
    });

    $api->group(["prefix" => "admin", "middleware" => ["role:admin"]], function ($api) {
        $api->resource("moderators", AdminUserController::class);
    });
});

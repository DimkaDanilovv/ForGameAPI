<?php

namespace App\Http\Controllers;

use App\Http\Requests\Boss\GetBossRequest;
use App\Http\Requests\Boss\StoreBossRequest;
use App\Http\Requests\Boss\UpdateBossRequest;
use App\Http\Services\FileService;
use App\Models\Boss;
use Illuminate\Http\Request;

class BossController extends Controller
{
    private $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetBossRequest $request)
    {
        $bosses = Boss::query();

        if ($keyword = $request->search) {
            $bosses->where(function ($query) use ($keyword) {
                $query->where("title", "like", "%$keyword%")
                    ->orWhere("name", "like", "%$keyword%")
                    ->orWhere("description", "like", "%$keyword%");
            });
        }

        $bosses->orderBy($request->input("order", "title"), $request->input("direction", "asc"));
        
        $bosses = $bosses->get();

        return response()->json($bosses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBossRequest $request)
    {
        $pathToFolder = "images/bosses/";
        $image = $this->fileService
            ->fileUpload($request->file("image"), $pathToFolder, $request->name);

        $boss = Boss::create([
            ...$request->all(),
            "image" => $image
        ]);

        return response()->json($boss);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $boss = Boss::findOrFail($id);

        return response()->json($boss);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBossRequest $request, string $id)
    {
        $boss = Boss::findOrFail($id);

        if ($file = $request->file("image")) {
            if (file_exists(public_path($boss->image))) unlink($boss->image);

            $title = $request->input("name", $boss->name);
            $fileName = $this->fileService->fileUpload($file, "images/bosses/", $title);
        }

        $boss->update([
            ...$request->all(),
            "image" => $fileName ?? $boss->image
        ]);

        return response()->json($boss);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $boss = Boss::findOrFail($id);

        if (file_exists(public_path($boss->image))) unlink($boss->image);

        $boss->delete();

        return response()->json(["message" => "Entry successfully deleted"]);
    }
}

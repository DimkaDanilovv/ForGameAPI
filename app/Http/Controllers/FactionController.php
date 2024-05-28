<?php

namespace App\Http\Controllers;

use App\Http\Requests\Faction\GetFactionRequest;
use App\Http\Requests\Faction\StoreFactionRequest;
use App\Http\Requests\Faction\UpdateFactionRequest;
use App\Http\Services\FileService;
use App\Models\Faction;

class FactionController extends Controller
{
    private $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetFactionRequest $request)
    {
        $factions = Faction::query();

        if ($keyword = $request->search) {
            $factions->where(function ($query) use ($keyword) {
                $query->where("title", "like", "%$keyword%")
                    ->orWhere("name", "like", "%$keyword%")
                    ->orWhere("description", "like", "%$keyword%");
            });
        }

        $factions->orderBy($request->input("order", "title"), 
        $request->input("direction", "asc"));

        $factions = $factions->get();

        return response()->json($factions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFactionRequest $request)
    {
        $image = $this->fileService
            ->fileUpload($request->file("image"), "images/factions/", $request->name);

        $faction = Faction::create([
            ...$request->all(),
            "image" => $image
        ]);

        return response()->json($faction);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faction = Faction::findOrFail($id);

        return response()->json($faction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFactionRequest $request, string $id)
    {
        $faction = Faction::findOrFail($id);

        if ($file = $request->file("image")) {
            if (file_exists(public_path($faction->image))) unlink($faction->image);

            $title = $request->input("name", $faction->name);
            $fileName = $this->fileService->fileUpload($file, "images/factions/", $title);
        }

        $faction->update([
            ...$request->all(),
            "image" => $fileName ?? $faction->image
        ]);

        return response()->json($faction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $factions = Faction::findOrFail($id);

        if (file_exists(public_path($factions->image))) unlink($factions->image);

        $factions->delete();

        return response()->json(["message" => "Entry successfully deleted"]);
    }
}

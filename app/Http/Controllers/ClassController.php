<?php

namespace App\Http\Controllers;

use App\Http\Requests\Classes\GetClassesRequest;
use App\Http\Requests\Classes\StoreClassesRequest;
use App\Http\Requests\Classes\UpdateClassesRequest;
use App\Http\Services\FileService;
use App\Models\PlayerClass;

class ClassController extends Controller
{
    private $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetClassesRequest $request)
    {
        $playerClasses = PlayerClass::query();

        if ($keyword = $request->search) {
            $playerClasses->where(function ($query) use ($keyword) {
                $query->where("title", "like", "%$keyword%")
                    ->orWhere("name", "like", "%$keyword%")
                    ->orWhere("description", "like", "%$keyword%");
            });
        }

        $playerClasses->orderBy($request->input("order", "title"), 
        $request->input("direction", "asc"));

        $playerClasses = $playerClasses->get();

        return response()->json($playerClasses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassesRequest $request)
    {
        $image = $this->fileService
            ->fileUpload($request->file("image"), "images/classes/", $request->name);

        $playerClass = PlayerClass::create([
            ...$request->all(),
            "image" => $image
        ]);

        return response()->json($playerClass);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $playerClass = PlayerClass::findOrFail($id);

        return response()->json($playerClass);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassesRequest $request, string $id)
    {
        $playerClass = PlayerClass::findOrFail($id);

        if ($file = $request->file("image")) {
            if (file_exists(public_path($playerClass->image))) unlink($playerClass->image);

            $title = $request->input("name", $playerClass->name);
            $fileName = $this->fileService->fileUpload($file, "images/classes/", $title);
        }

        $playerClass->update([
            ...$request->all(),
            "image" => $fileName ?? $playerClass->image
        ]);

        return response()->json($playerClass);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $playerClass = PlayerClass::findOrFail($id);

        if (file_exists(public_path($playerClass->image))) unlink($playerClass->image);

        $playerClass->delete();

        return response()->json(["message" => "Entry successfully deleted"]);
    }
}

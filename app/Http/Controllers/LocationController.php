<?php

namespace App\Http\Controllers;

use App\Http\Requests\Location\GetLocationRequest;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Http\Services\FileService;
use App\Models\Location;

class LocationController extends Controller
{
    private $fileService;

    public function __construct()
    {
        $this->fileService = new FileService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GetLocationRequest $request)
    {
        $locations = Location::query();

        if ($keyword = $request->search) {
            $locations->where(function ($query) use ($keyword) {
                $query
                    ->where("title", "like", "%$keyword%")
                    ->orWhere("name", "like", "%$keyword%")
                    ->orWhere("description", "like", "%$keyword%");
            });
        }

        $locations->orderBy(
            $request->input("order", "title"),
            $request->input("direction", "asc")
        );

        $perPage = $request->input("per_page", 10);
        $page = $request->input("page", 1);

        $locations = $locations
            ->paginate($perPage, ["*"], "page", $page);

        return response()->json($locations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        $image = $this->fileService
            ->fileUpload($request->file("image"), "images/locations/", $request->name);

        $location = Location::create([
            ...$request->all(),
            "image" => $image
        ]);

        return response()->json($location);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location = Location::findOrFail($id);

        return response()->json($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, string $id)
    {
        $location = Location::findOrFail($id);

        if ($file = $request->file("image")) {
            if (file_exists(public_path($location->image))) unlink($location->image);

            $title = $request->input("name", $location->name);
            $fileName = $this->fileService->fileUpload($file, "images/locations/", $title);
        }

        $location->update([
            ...$request->all(),
            "image" => $fileName ?? $location->image
        ]);

        return response()->json($location);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id);

        if (file_exists(public_path($location->image))) unlink($location->image);

        $location->delete();

        return response()->json(["message" => "Entry successfully deleted"]);
    }
}

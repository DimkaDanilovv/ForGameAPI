<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewLocation() //функция просмотра не готова
    {
        if (! $locations = Location::all()) {
            throw new NotFoundHttpException('Locations not found');
        }
        return $locations;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function deleteLocation(Request $request)
    {

    $location = Location::find("id", $request->get('id'));

    if ($location) {
        // Если фракция найдена, удалить её
        $location->delete();
        return response()->json(['message' => 'Локация успешно удалена.'], 200);
    } else {
        // Если фракция не найдена, возвращаем сообщение об ошибке
        return response()->json(['error' => 'Локация не найдена.'], 404);
    }
    }

    public function createLocation(Request $request)
    {
        $credentials = $request->only('name','title', 'description');

        $location = Location::create([]);
    }

    public function editLocation(Request $request)
    {
    if ($request->isMethod('put')) {

        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $location = Location::find($validatedData['id']);

        if ($location) {
            $location->update([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
            ]);
            return response()->json(['message' => 'Локация успешно обновлена.', 'location' => $location], 200);
        } else {
            return response()->json(['error' => 'Локация не найдена.'], 404);
        }
    } else {
        return response()->json(['error' => 'Неверный метод запроса. Используйте метод PUT.'], 405);
    }
}
}

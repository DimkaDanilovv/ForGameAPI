<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerClass;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewPlayerClass() //функция просмотра не готова
    {
        if (! $PlayerClasses = PlayerClass::all()) {
            throw new NotFoundHttpException('Classes not found');
        }
        return $PlayerClasses;
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

    public function deletePlayerClass(Request $request)
    {

    $PlayerClass = PlayerClass::find("id", $request->get('id'));

    if ($PlayerClass) {
        // Если фракция найдена, удалить её
        $PlayerClass->delete();
        return response()->json(['message' => 'Класс успешн удален.'], 200);
    } else {
        // Если фракция не найдена, возвращаем сообщение об ошибке
        return response()->json(['error' => 'Класс не найден.'], 404);
    }
    }

    public function createPlayerClass(Request $request)
    {
        $credentials = $request->only('name','title', 'description');

        $PlayerClass = PlayerClass::create([]);
    }

    public function editPlayerClass(Request $request)
    {
    if ($request->isMethod('put')) {

        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $PlayerClass = PlayerClass::find($validatedData['id']);

        if ($PlayerClass) {
            $PlayerClass->update([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
            ]);
            return response()->json(['message' => 'Класс успешно обновлен.', 'PlayerClass' => $PlayerClass], 200);
        } else {
            return response()->json(['error' => 'Класс не найден.'], 404);
        }
    } else {
        return response()->json(['error' => 'Неверный метод запроса. Используйте метод PUT.'], 405);
    }
}

}

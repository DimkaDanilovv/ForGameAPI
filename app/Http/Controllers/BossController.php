<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boss;

class BossController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewBoss() //функция просмотра не готова
    {
        if (! $bosses = Boss::all()) {
            throw new NotFoundHttpException('Bosses not found');
        }
        return $bosses;
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
    public function deleteBoss(Request $request)
    {

    $boss = Boss::find("id", $request->get('id'));

    if ($boss) {
        // Если фракция найдена, удалить её
        $boss->delete();
        return response()->json(['message' => 'Босс успешно удален.'], 200);
    } else {
        // Если фракция не найдена, возвращаем сообщение об ошибке
        return response()->json(['error' => 'Босс не найден.'], 404);
    }
    }

    public function createBoss(Request $request)
    {
        $credentials = $request->only('name','title', 'description');

        $boss = Boss::create([]);
    }

    public function editBoss(Request $request)
    {
    if ($request->isMethod('put')) {

        $validatedData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $boss = Boss::find($validatedData['id']);

        if ($boss) {
            $boss->update([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
            ]);
            return response()->json(['message' => 'Босс успешно обновлен.', 'boss' => $boss], 200);
        } else {
            return response()->json(['error' => 'Босс не найден.'], 404);
        }
    } else {
        return response()->json(['error' => 'Неверный метод запроса. Используйте метод PUT.'], 405);
    }
}
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faction;

class FactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewFaction() //функция просмотра не готова
    {
        return view ('faction.index');
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
    public function deleteFaction(Request $request)
    {

    $faction = Faction::find("id", $request->get('id'));

    if ($faction) {
        // Если фракция найдена, удалить её
        $faction->delete();
        return response()->json(['message' => 'Фракция успешно удалена.'], 200);
    } else {
        // Если фракция не найдена, возвращаем сообщение об ошибке
        return response()->json(['error' => 'Фракция не найдена.'], 404);
    }
    }

    public function createFaction(Request $request)
    {
        $credentials = $request->only('name','title', 'description');

        $faction = Faction::create([]);
    }

    public function editFaction(Request $request)
    {
        if ($request->methood === 'POST') {
        Faction::where("id", $request->get('id'))->update([
            'name' => $request->get('name'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);    
        }
    }
}

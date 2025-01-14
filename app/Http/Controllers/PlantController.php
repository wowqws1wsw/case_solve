<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plants = Plant::all(); 
        $totalPlants = $plants->count();
    
        return view('index', compact('plants', 'totalPlants'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required|in:Bunga,Obat,Buah-Buahan,Kacang-Kacangan,Rumput',
            'kode_plant' => 'required|unique:plants,kode_plant',
        ]);

        Plant::create([
            'kode_plant' => $request->kode_plant,
            'name' => $request->name,
            'type' => $request->type,
            'additional' => $request->additional ?? "-",
        ]);

        return redirect()->route('plants.index')->with('add', 'Success add new plant!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $plant = Plant::findOrFail($id); 
    return view('edit', compact('plant'));
}
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'growth' => 'required|string',
            'additional' => 'nullable|string',
        ]);
    
        $plant = Plant::findOrFail($id);
    
        $growth = $plant->growth ?? [];
    
        $newGrowth = [
            "tanggal" => date("d-m-Y"),
            "growth" => $request->growth,
        ];
        $growth[] = $newGrowth;
    
        // Update data plant
        $plant->update([
            'name' => $request->name,
            'type' => $request->type,
            'additional' => $request->additional,
            'growth' => $growth,
        ]);

        return redirect()->route('plants.index')->with('success', 'Plant updated successfully!');
    }
    




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $plant = Plant::findOrFail($id);
    $plant->delete();

    return redirect()->route('plants.index')->with('delete', 'Plant deleted successfully!');
}

}

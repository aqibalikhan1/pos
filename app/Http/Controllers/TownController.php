<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $towns = Town::latest()->get();
        return view('pos.towns.index', compact('towns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pos.towns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Town::create($validated);

        return redirect()->route('towns.index')
            ->with('success', 'Town created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Town $town)
    {
        return view('pos.towns.show', compact('town'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Town $town)
    {
        return view('pos.towns.edit', compact('town'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Town $town)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $town->update($validated);

        return redirect()->route('towns.index')
            ->with('success', 'Town updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Town $town)
    {
        $town->delete();

        return redirect()->route('towns.index')
            ->with('success', 'Town deleted successfully.');
    }
}

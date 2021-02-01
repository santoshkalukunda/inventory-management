<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Unit $unit)
    {
        if (!$unit) {
        $unit = new Unit;
    }
    $units=Unit::latest()->paginate(20);
    return view('unit.index',compact('units','unit'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        Unit::create($request->validated());
        return redirect()->route('units.index')->with('success', 'Unit Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return $this->index($unit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return redirect()->route('units.index')->with('success', 'unit Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->back()->with('success', 'Unit deleted');
    }
    public function search(Request $request){
        $units = new Unit;
        if ($request->has('name')) {
            if ($request->name != null)
                $units = $units->where('name', 'LIKE', ["$request->name%"]);
        }
        $units=$units->paginate();
        $unit=null;
        if (!$unit) {
            $unit = new Unit;
        }
        return view('unit.index',compact('units','unit'));
    }
}

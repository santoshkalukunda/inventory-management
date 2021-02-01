<?php

namespace App\Http\Controllers;

use App\Http\Requests\DealerRequest;
use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealers=Dealer::latest()->paginate(20);
        return view('dealer.index',compact('dealers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Dealer $dealer=null)
    {
        if (!$dealer) {
            $dealer = new Dealer;
        }
        return view('dealer.create',compact('dealer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerRequest $request)
    {
        $dealers=Dealer::create($request->validated());
        return redirect()->route('dealers.index')->with('success','Dealers Registration Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function show(Dealer $dealer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealer $dealer)
    {
        return view('dealer.edit',compact('dealer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(DealerRequest $request, Dealer $dealer)
    {
        $dealers=$dealer->update($request->validated());
        return redirect()->back()->with('success','Dealers Update Successfull');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealer $dealer)
    {
        $dealer->delete();
        return redirect()->back()->with('success','Dealer Deleted');
    }
    public function search(Request $request){
        $dealers = new Dealer;
      
        if ($request->has('name')) {
            if ($request->name != null)
                $dealers = $dealers->where('name', 'LIKE', ["$request->name%"]);
        }
        if ($request->has('email')) {
            if ($request->email != null)
                $dealers = $dealers->where('email', 'LIKE', ["$request->email%"]);
        }
        if ($request->has('phone')) {
            if ($request->phone != null)
                $dealers = $dealers->where('phone',["$request->phone"]);
        }
        if ($request->has('address')) {
            if ($request->address != null)
            $dealers = $dealers->where('address', 'LIKE', ["$request->address%"]);
        }
        if ($request->has('pan_vat')) {
            if ($request->pan_vat != null)
                $dealers = $dealers->where('pan_vat', ["$request->pan_vat"]);
        }
        if ($request->has('reg_no')) {
            if ($request->reg_no != null)
                $dealers = $dealers->where('reg_no', ["$request->reg_no"]);
        }
        $dealers = $dealers->paginate();
        return view('dealer.index', compact('dealers'));
    }
}

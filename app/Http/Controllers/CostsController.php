<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cost;

class CostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costs = Cost::all()->where('archive', 0);

        return view('costs.index')->with('costs', $costs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('costs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cost = Cost::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'price' => $request['price'],
        ]);

        $cost->save();

        return redirect('costs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cost = Cost::find($id);

        return view('costs.edit')->with('cost', $cost);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cost = Cost::find($id);

        $cost->title = $request['title'];
        $cost->content = $request['content'];
        $cost->price = $request['price'];

        $cost->save();

        return redirect('costs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cost = Cost::find($id);

        $cost->delete();
        return redirect('costs');

    }

    public function archive($id){
        $cost = Cost::find($id);
        $cost->archive = 1;
        $cost->save();

        if($cost->save()){
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }else{
            return 'err';
        }
    }
}

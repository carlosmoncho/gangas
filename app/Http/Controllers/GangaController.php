<?php

namespace App\Http\Controllers;

use App\Http\Requests\GangaRequest;
use App\Models\Category;
use App\Models\Ganga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GangaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $gangas = Ganga::orderByRaw('(price - discount_price) desc')->take(20)->get();
        $collection = collect($gangas)->sortDesc();
        $gangas = $collection->groupBy('category_id');
        $gangas->all();
        return view('gangas.index',compact('gangas','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('gangas.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GangaRequest $request)
    {
        $ganagas = Ganga::orderBy('id', 'desc')->first();
        $numimg= $ganagas->id +1;
        $ganga = new Ganga();
        $ganga->title = $request->get('title');
        $ganga->description = $request->get('description');
        $ganga->URL = $request->get('url');
        $ganga->points = $request->get('points');
        $ganga->price = $request->get('price');
        $ganga->discount_price = $request->get('discount_price');
        $ganga->available = $request->get('available');
        $ganga->category_id =  $request->get('category_id');
        if ($request->hasFile('img')){
            $file = $request->file('img');
            $path = storage_path().'/app/public/img';
            $fileName = $numimg.'-ganga-severa.'.$file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $ganga->img = '/storage/img/'.$fileName;
        }
        $ganga->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ganga = Ganga::find($id);
        $categories = Category::all();
        return view('gangas.show',compact('ganga','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ganga = Ganga::find($id);
        $categories = Category::all();
        return view('gangas.edit',compact('ganga','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GangaRequest $request, $id)
    {
        $ganga = Ganga::findOrFail($id);
        $ganga->title = $request->get('title');
        $ganga->description = $request->get('description');
        $ganga->URL = $request->get('url');
        $ganga->points = $request->get('points');
        $ganga->price = $request->get('price');
        $ganga->discount_price = $request->get('discount_price');
        $ganga->available = $request->get('available');
        $ganga->category_id = $request->get('category_id');
        if ($request->hasFile('img')){
            $file = $request->file('img');
            $path = storage_path().'/app/public/img';
            $fileName = $id.'-ganga-severa.'.$file->getClientOriginalExtension();
            $file->move($path, $fileName);
            $ganga->img = '/storage/img/'.$fileName;
        }
        $ganga->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ganga::find($id)->delete();
        $gangas = Ganga::all()->groupBy('category_id');
        $categories = Category::orderBy('id', 'ASC')->paginate(8);
        return view('projecte', compact('categories','gangas'));
    }
}

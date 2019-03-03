<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $search = $request->search;
        $option = $request->option;

        if ($search == '') {
            $category = Category::orderBy('id','desc')->paginate(10);
        } else {
            $category = Category::where($option,'like','%'. $search .'%')->orderBy('id','desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total' => $category->total(),
                'current_page' => $category->currentPage(),
                'per_page' => $category->perPage(),
                'last_page' => $category->lastPage(),
                'from' => $category->firstItem(),
                'to' => $category->lastItem()
            ],
            'categories' => $category
        ];
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
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->state = '1';
        $category->save();
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
     * @param  \Illuminate\Http\Request  $request
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->state = 1;
        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * disable the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeState(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $category = Category::findOrFail($request->id);
        if ($category->state == '1') {
            $category->state = '0';
        } else {
            $category->state = '1';
        }
        $category->save();
    }
}

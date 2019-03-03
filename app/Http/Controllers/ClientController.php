<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $search = $request->search;
        $option = $request->option;

        if ($search == '') {
            $clients = Person::orderBy('id','desc')->paginate(10);
        } else {
            $clients = Person::where($option,'like','%'. $search .'%')->orderBy('id','desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total' => $clients->total(),
                'current_page' => $clients->currentPage(),
                'per_page' => $clients->perPage(),
                'last_page' => $clients->lastPage(),
                'from' => $clients->firstItem(),
                'to' => $clients->lastItem()
            ],
            'categories' => $clients
        ];
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
        $client = new Person();
        $client->name = $request->name;
        $client->type_document = $request->type_document;
        $client->num_document = $request->num_document;
        $client->direction = $request->direction;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->state = '1';
        $client->save();
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
        $client = Person::findOrFail($request->id);
        $client->name = $request->name;
        $client->type_document = $request->type_document;
        $client->num_document = $request->num_document;
        $client->direction = $request->direction;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->state = '1';
        $client->save();
    }

    /**
     * changeState the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeState(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $client = Person::findOrFail($request->id);
        if ($client->state == '1') {
            $client->state = '0';
        } else {
            $client->state = '1';
        }
        $client->save();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Provider;
use App\Person;

class ProviderController extends Controller
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
            $providers = Provider::join('person','provider.id','=','person.id')
            ->select('person.id', 'person.name', 'person.type_document', 'person.num_document', 'person.id', 
            'person.direction', 'person.phone', 'person.email', 'provider.contact', 'provider.contact_phone')
            ->orderBy('person.id','desc')->paginate(3);
        } else {
            $providers = Provider::join('person','provider.id','=','person.id')
            ->select('person.id', 'person.name', 'person.type_document', 'person.num_document', 'person.id', 
            'person.direction', 'person.phone', 'person.email', 'provider.contact', 'provider.contact_phone')
            ->where('person.'.$option,'like','%'. $search .'%')->orderBy('person.id','desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total' => $providers->total(),
                'current_page' => $providers->currentPage(),
                'per_page' => $providers->perPage(),
                'last_page' => $providers->lastPage(),
                'from' => $providers->firstItem(),
                'to' => $providers->lastItem()
            ],
            'providers' => $providers
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
        try {
            DB::beginTransaction();
            $person = new Person();
            $person->name = $request->name;
            $person->type_document = $request->type_document;
            $person->num_document = $request->num_document;
            $person->direction = $request->direction;
            $person->phone = $request->phone;
            $person->email = $request->email;
            $person->state = '1';
            $person->save();

            $provider = new Provider();
            $provider->contact = $request->$contact;
            $provider->contact_phone = $request->contact_phone;
            $provider->id = $person->id;
            $provider->save();

            DB::commint();

        } catch (Exteption $e) {
            DB::rollBack();
        }       
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
        try {
            DB::beginTransaction();
            $provider = Provider::findOrFail($request->id);
            $person = Person::findOrFail($provider->id);

            $person->name = $request->name;
            $person->type_document = $request->type_document;
            $person->num_document = $request->num_document;
            $person->direction = $request->direction;
            $person->phone = $request->phone;
            $person->email = $request->email;
            $person->state = '1';
            $person->save();

            $provider->contact = $request->$contact;
            $provider->contact_phone = $request->contact_phone;
            $provider->save();

            DB::commint();

        } catch (Exteption $e) {
            DB::rollBack();
        }
    }
}

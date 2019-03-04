<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Person;

class UserController extends Controller
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
            $users = User::join('person','users.id','=','person.id')
            ->join('roles','users.id_rol','=','roles.id')
            ->select('person.id', 'person.name', 'person.type_document', 'person.num_document', 'person.id', 
            'person.direction', 'person.phone', 'person.email', 'users.username', 'users.password',
            'users.state', 'users.id_rol','roles.name as rol')
            ->orderBy('person.id','desc')->paginate(3);
        } else {
            $users = User::join('person','users.id','=','person.id')
            ->join('roles','users.id_rol','=','roles.id')
            ->select('person.id', 'person.name', 'person.type_document', 'person.num_document', 'person.id', 
            'person.direction', 'person.phone', 'person.email', 'users.username', 'users.password',
            'users.state', 'users.id_rol','roles.name as rol')
            ->where('person.'.$option,'like','%'. $search .'%')->orderBy('person.id','desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem()
            ],
            'users' => $users
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

            $user = new User();
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->state = '1';
            $user->id_rol = $request->id_rol;

            $user->id = $person->id;
            $user->save();

            DB::commit();

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
            $user = User::findOrFail($request->id);
            $person = Person::findOrFail($user->id);

            $person->name = $request->name;
            $person->type_document = $request->type_document;
            $person->num_document = $request->num_document;
            $person->direction = $request->direction;
            $person->phone = $request->phone;
            $person->email = $request->email;
            $person->state = '1';
            $person->save();

            $user->username = $request->username;
            $user->state = '1';
            $user->id_rol = $request->id_rol;
            $user->save();

            DB::commit();

        } catch (Exteption $e) {
            DB::rollBack();
        }
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
        $user = User::findOrFail($request->id);
        if ($user->state == '1') {
            $user->state = '0';
        } else {
            $user->state = '1';
        }
        $user->save();
    }
}

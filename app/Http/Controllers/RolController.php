<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
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
            $roles = Rol::orderBy('id','desc')->paginate(10);
        } else {
            $roles = Rol::where($option,'like','%'. $search .'%')->orderBy('id','desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total' => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page' => $roles->perPage(),
                'last_page' => $roles->lastPage(),
                'from' => $roles->firstItem(),
                'to' => $roles->lastItem()
            ],
            'roles' => $roles
        ];
    }

    /**
     * Display a categories of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function roles(Request $request)
    {   
        if (!$request->ajax()) return redirect('/'); 
        $roles = Rol::where('state','=', '1')
        ->select('id','name')->orderBy('name','asc')->get();

        return ['roles' => $roles];
    }
}

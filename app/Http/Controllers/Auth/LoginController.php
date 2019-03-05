<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (Auth::attempt(['username'=> $request->username, 'password'=> $request->password, 'state' => 1])) {
            return redirect()->route('main');
        }
        return back()
        ->withErrors(['username' => trans('auth.failed')])
        ->withInput(request(['username']));
    }

    protected function validateLogin(Request $request){
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}

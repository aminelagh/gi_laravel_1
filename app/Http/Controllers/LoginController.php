<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    function login(){
        return view("login");
    }

    function submitLogin(Request $request){
        dump($request);
        //return view("login");
    }

    public function store(Request $request)
    {
      $validatedData = $request->validate([
          'login' => 'required|max:5',
          'password' => 'required',
      ]);

      return redirect('/tech-dash');
    }


}

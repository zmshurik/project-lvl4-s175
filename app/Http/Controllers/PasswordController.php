<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.pwdchange');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|different:current-password|confirmed',
        ]);

        $user = Auth::user();

        if (!(Hash::check($request->get('current-password'), $user->password))) {
            flash('The password is incorrect')->error()->important();
            return redirect()->back();
        }

        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        flash('Password changed successfully !')->success()->important();

        return redirect()->back();
    }
}

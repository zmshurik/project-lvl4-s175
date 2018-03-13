<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $users = User::paginate(10);
        return view('users.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        if ($user->id != User::find($id)->id) {
            redirect()->route('users.edit', ['id' => $user->id]);
        }
        return view('users.profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255',  Rule::unique('users')->ignore($user->id)]
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        flash('Changes saved successfuly')->success();
        return redirect()->route('users.edit', ['id' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user->delete();
        flash('Your account deleted successfuly')->error();
        return redirect('/');
    }

    public function changePwdShow()
    {
        return view('users.pwdchange');
    }

    public function changePwdStore(Request $request)
    {
        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|different:current-password|confirmed',
        ]);

        $user = Auth::user();

        if (!(Hash::check($request->get('current-password'), $user->password))) {
            flash('The password is incorrect')->error();
            return redirect()->back();
        }

        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        flash('Password changed successfully !')->success();

        return redirect()->back();
    }
}

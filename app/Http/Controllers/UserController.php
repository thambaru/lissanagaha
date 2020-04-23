<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
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

    public function login(Request $request)
    {
        $request->validate(
            [
                'emp_id' => 'required|email',
                'password' => 'required'
            ]
        );

        $credentials = $request->only('emp_id', 'password');

        if (User::where('division', $request->get("division"))->count() > 50)
            return redirect()->route('home')->withErrors(['teamFull', true]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            Cookie::queue('userID', $user->id, 360);
            Cookie::queue('division', $user->division, 360);

            return redirect()->route('answer.create');

        } else {
            return redirect()->back()->withErrors(['Invalid Email/PIN'])->withInput();
        }
    }

    static function getDivisionUserCount($division)
    {
        return User::where('division', $division)->count();
    }
}

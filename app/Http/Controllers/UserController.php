<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
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
        $request->validate(
            [
                'ip' => 'required',
                'emp_id' => 'required|unique:users|numeric',
                'division' => 'required'
            ]
        );

        if (User::where('division', $request->get("division"))->count() > 50) {
            return redirect()->route('home')->withErrors(['teamFull',true]);
        } else {
            $users = User::updateOrcreate(['id' => $request->get('id')], [
                "ip" => $request->get("ip"),
                "emp_id" => $request->get("emp_id"),
                "division" => $request->get("division")
            ]);

            Cookie::queue('userID', $users->id, 360);
            Cookie::queue('division', $request->get("division"), 360);
            return redirect()->route('answer.create');

            // $response->withCookie(cookie()->forever('userID', '$users->id'));
            // return $users->id;
        }
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

    static function getDivisionUserCount($division)
    {
        return User::where('division', $division)->count();
    }


    public static  $messages = array(
        'emp_id.required' => 'You have already logged in somewhere', 
    );
}

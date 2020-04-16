<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Filters\Common;
use Illuminate\Http\Request;

class LissanagahaController extends Controller
{
    public function home()
    {
        $teams = Common::$divisions;
        $teamsScore = [];
        foreach ($teams as $key => $value) {
            array_push($teamsScore, Answer::where('division', $key)->sum('value'));
        }
        // return $teamsScore;
        $final  = array_combine( $teams, $teamsScore );
        return view('index')->with(['teams' => $teams, 'score'=> $teamsScore, 'final' =>$final]);
    }

    public function api()
    {
        $teams = Common::$divisions;
        $teamsScore = [];
        foreach ($teams as $key => $value) {
            array_push($teamsScore, Answer::where('division', $key)->sum('value'));
        }
       $final  = array_combine( $teams, $teamsScore );
        return $final;
    }
}

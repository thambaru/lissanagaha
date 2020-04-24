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
            $answerSum = Answer::where('division', $key)->sum('value');
            $score = $answerSum <= 0 ? 0 :$answerSum;
            array_push($teamsScore, $score);
        }
        // return $teamsScore;
        $final  = array_combine( $teams, $teamsScore );
        return view('index')->with(['teams' => $teams, 'score'=> $teamsScore, 'final' =>$final]);
    }

    public static function api()
    {
        return Common::getScores();
    }
}

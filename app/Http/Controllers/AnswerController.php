<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Filters\Common;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    static $config = [
        'randFirst' => 0,
        'randLast' => 8,
        'disallowingMinutes' => 5,
        'maxLimit' => 2000
    ];


    public function create()
    {

        $lg = $this;
        $randomNumber = self::getLuckyNumber();
        $question = Common::$randomQuistion[$randomNumber];
        $teams = Common::$divisions;
        $teamsScore = [];
        foreach ($teams as $key => $value) {
            array_push($teamsScore, Answer::where('division', $key)->sum('value'));
        }
        // return $teamsScore;
        $final  = array_combine( $teams, $teamsScore );



        return view('solve', compact('lg'))->with('question', $question)->with('q', $randomNumber)->with('class', true)->with(['teams' => $teams, 'score'=> $teamsScore, 'final' =>$final]);;

 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lg = $this;
        $request->validate([
            'answer' => 'required'
        ]);

        $userId = $request->cookie('userID');
        $division = $request->cookie('division');

        if (self::isEligible()) {
            if ($request->get('answer') == Common::$randomAnswers[$request->get('q')]) {

                $answers = Answer::updateOrcreate(['id' => $request->get('id')], [
                    'user_id' => $userId,
                    'division' => $division,
                    'value' => 10,
                ]);

                return redirect()->back()->withErrors(['message' => 'Congrats! You made your team climb up the Lissana Gaha','errorType'=>'success']);
            } else if ($request->get('answer') == 0) {
                $answers = Answer::updateOrcreate(['id' => $request->get('id')], [
                    'user_id' => $userId,
                    'division' => $division,
                    'value' => -10,
                ]);
                return redirect()->back()->withErrors(['message' => " Time's up and you slipped down the Lissana Gaha because you didn't answer",'errorType'=>'danger']);
            } else {
                $answers = Answer::updateOrcreate(['id' => $request->get('id')], [
                    'user_id' => $userId,
                    'division' => $division,
                    'value' => -10,
                ]);
                return redirect()->back()->withErrors(['message' => 'Oops! Your team lost points because you got the answer wrong','errorType'=>'danger']);
            }
        } else {
            return redirect()->back();
        }
    }

    function getLuckyNumber()
    {
        $luckyNumber = rand(self::$config['randFirst'], self::$config['randLast']);

        return $luckyNumber;
    }

    static function myResult()
    {
        $userId  =  request()->cookie('userID');
        return Answer::where('user_id', $userId)->sum('value');
    }

    static function getLast()
    {
        $userId  =  request()->cookie('userID');
        return Answer::where('user_id', $userId)->orderBy('id', 'desc')->first();
    }

    static function isExisting()
    {
        return !empty(self::getLast());
    }

    static function isEligible()
    {
        $last = self::getLast();

        if (empty($last))
            return true;

        return $last->created_at->addMinutes(self::$config['disallowingMinutes'])->lt(Carbon::now());
    }

    public static  $messages = array(
        'emp_id.unique:users' => 'You have already logged in somewhere', 
    );
}

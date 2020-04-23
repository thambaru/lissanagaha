<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Filters\Common;
use App\RandomQuestion;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    static $config = [];

    function __construct()
    {
        self::$config = Common::$config;
    }

    public function index()
    {
        return redirect()->route('answer.create');
    }

    public function create()
    {

        $lg = $this;

        $randomQuestion = RandomQuestion::all()->random();
        $randomQuestionId = $randomQuestion->id;
        $question = $randomQuestion->question;

        $teams = Common::$divisions;
        $teamsScore = [];
        foreach ($teams as $key => $value) {
            array_push($teamsScore, Answer::where('division', $key)->sum('value'));
        }
        // return $teamsScore;
        $final  = array_combine($teams, $teamsScore);



        return view('solve', compact('lg'))->with('question', $question)->with('q', $randomQuestionId)->with('class', true)->with(['teams' => $teams, 'score' => $teamsScore, 'final' => $final]);;
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

        $userId = $request->cookie('userID');
        $division = $request->cookie('division');

        if (self::isEligible()) {
            if ($request->get('answer') == RandomQuestion::find($request->get('q'))->answer) {

                $answers = Answer::updateOrcreate(['id' => $request->get('id')], [
                    'user_id' => $userId,
                    'division' => $division,
                    'value' => self::$config['plusPoints'],
                ]);

                $message = ['message' => "Congrats, You climbed up!", 'errorType' => "success"];
            } else {

                $answers = Answer::updateOrcreate(['id' => $request->get('id')], [
                    'user_id' => $userId,
                    'division' => $division,
                    'value' => self::$config['minusPoints'],
                ]);
                if ($request->get('answer') == 0 || !$request->filled('answer'))
                    $message = ['message' => "Time's up and you slipped down!", 'errorType' => "danger"];
                else
                    $message = ['message' => "Oops! You've lost " . self::$config['minusPoints'] . " points for the team for that wrong answer", 'errorType' => "danger"];
            }
            return redirect()->back()->withErrors($message);
        } else {
            return redirect()->back();
        }
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

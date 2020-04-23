<?php

namespace App\Filters;

use App\Answer;

class Common
{
    static $config = [
        'randomQuestionCount' => 100,
        'disallowingMinutes' => 1, //3,
        'questionAnswerSeconds' => 1000005,
        'maxLimit' => 2000,
        'plusPoints' => 10,
        'minusPoints' => -10
    ];

    static $divisions = [
        "Team A", //0
        "Team B", //1
        "Team C", //2
        "Team D", //3
    ];

    public static function getScores()
    {
        $teams = Common::$divisions;
        $teamsScore = [];
        foreach ($teams as $key => $value) {
            array_push($teamsScore, Answer::where('division', $key)->sum('value'));
        }
        $final  = array_combine($teams, $teamsScore);
        return $final;
    }

    public static function hasAnyoneReachedLimit()
    {
        $teams = Common::$divisions;
        foreach ($teams as $key => $value) {
            if (Answer::where('division', $key)->sum('value') >= self::$config['maxLimit'])
                return true;
        }
        return false;
    }

    public static function generateRandomQuestion()
    {
        $ops = ['-', '+', '*'];

        $answer = -1;
        while ($answer <= 5 || $answer >= 99) {

            $num1 = rand(10, 100);
            $num2 = rand(10, 100);

            $rand_op = array_rand($ops);
            $op = $ops[$rand_op];

            $question = "$num1 $op $num2";
            $answer = eval("return $num1 $op $num2;");
        }

        return compact("question", "answer");
    }
}

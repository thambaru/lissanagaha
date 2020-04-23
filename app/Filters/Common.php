<?php

namespace App\Filters;

use App\Answer;

class Common
{
    static $config = [
        'randFirst' => 0,
        'randLast' => 8,
        'disallowingMinutes' => 1, //3,
        'questionAnswerSeconds' => 5,
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

    static $randomQuestions = ["15x7", "56+47", "8x4", "6+99", "69+85", "81-17", "98/7", "2520-148", "56-9"];
    static $randomAnswers = ["105", "103", "32", "105", "154", "64", "14", "2372", "47"];

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
}

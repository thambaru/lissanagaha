<?php

use App\Filters\Common;
use App\RandomQuestion;
use Illuminate\Database\Seeder;

class RandomQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionCount = Common::$config['randomQuestionCount'];

        RandomQuestion::truncate();

        for($i=0;$i<=$questionCount;$i++){

            $newQuestion = Common::generateRandomQuestion();

            $randonQuestion=new RandomQuestion;

            $randonQuestion->question = $newQuestion['question'];
            $randonQuestion->answer = $newQuestion['answer'];
            
            $randonQuestion->save();
        }
        
    }
}

<?php

use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Question::class, 24)->create()->each(
            function(App\Question $question){

            $number_answer = 4;
            
            for ($i=0; $i < $number_answer; $i++) { 
                $question->answers()->save(factory(App\Answer::class)->make());
            }
        });
    }
}

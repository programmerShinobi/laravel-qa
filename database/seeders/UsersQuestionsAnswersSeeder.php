<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersQuestionsAnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // UsersQuestionsAnswersSeeder
        DB::table('answers')->delete();
        DB::table('questions')->delete();
        DB::table('users')->delete();

        User::factory(3)->create()->each(function ($u) {
            $u->questions()
                ->saveMany(
                    Question::factory(rand(1, 5))->make()
                )->each(function ($q) {
                    $q->answers()->saveMany(Answer::factory(rand(1, 5))->make());
                });
        });
    }
}

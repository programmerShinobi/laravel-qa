<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\VotablesSeeder;
use Database\Seeders\FavoritesSeeder;
use Database\Seeders\UsersQuestionsAnswersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersQuestionsAnswersSeeder::class,
            FavoritesSeeder::class,
            VotablesSeeder::class,
        ]);


        // // UsersQuestionsAnswersSeeder
        // DB::table('answers')->delete();
        // DB::table('questions')->delete();
        // DB::table('users')->delete();

        // User::factory(3)->create()->each(function ($u) {
        //     $u->questions()
        //         ->saveMany(
        //             Question::factory(rand(1, 10))->make()
        //         )->each(function ($q) {
        //             $q->answers()->saveMany(Answer::factory(rand(1, 10))->make());
        //         });
        // });


        // //FavoritesSeeder
        // DB::table('favorites')->delete();

        // $users = User::pluck('id')->all();
        // $numberOfUsers = count($users);

        // foreach (Question::all() as $question) {
        //     for ($i = 0; $i < rand(0, $numberOfUsers); $i++) {
        //         $user = $users[$i];

        //         $question->favorites()->attach($user);
        //     }
        // }


        // // VotablesSeeder
        // DB::table('votables')->delete();

        // $users = User::all();
        // $numberOfUsers = $users->count();
        // $votes = [-1, 1];

        // foreach (Question::all() as $question) {
        //     for ($i = 0; $i < rand(0, $numberOfUsers); $i++) {
        //         $user = $users[$i];
        //         $user->voteQuestion($question, $votes[rand(0, 1)]);
        //     }
        // }

        // foreach (Answer::all() as $answer) {
        //     for ($i = 0; $i < rand(0, $numberOfUsers); $i++) {
        //         $user = $users[$i];
        //         $user->voteAnswer($answer, $votes[rand(0, 1)]);
        //     }
        // }
    }
}

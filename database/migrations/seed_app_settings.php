<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Slide;
use App\Models\Question;
use App\Models\Option;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Dom',
                'email' => 'dom@example.com',
                'password' => bcrypt('password')
            ],
            [
                'name' => 'Ellie',
                'email' => 'ellie@example.com',
                'password' => bcrypt('password')
            ],
        ]);

        $slide = Slide::create([
            'title' => 'this is a placeholder',
            'image_path' => 'it is not really here',
        ]);

        $question = Question::create([
            'slide_id' => $slide->id,
            'text' => 'Click on the head.',
        ]);

        Option::create([
            'slide_id' => $slide->id,
            'question_id' => $question->id,
            'label' => 'wrong answer',
            'is_correct' => 0,
            'zone' => null,
        ]);

        Option::create([
            'slide_id' => $slide->id,
            'question_id' => $question->id,
            'label' => 'right answer',
            'is_correct' => 1,
            'zone' => null,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Models\Question;
use App\Models\Option;
use App\Models\Slide;
use App\Models\SlideOption;

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

        $image1 = Image::create([
            'title' => 'Human Body',
            'path' => 'images/human-body.png',
        ]);

        $question = Question::create([
            'image_id' => $image1->id,
            'text' => 'Click on the head.',
        ]);
        
        $slide = Slide::create([
            'image_id' => $image1->id,
            'question_id' => $question->id,
        ]);

        $image2 = Image::create([
            'title' => 'Chopr Logo',
            'path' => 'images/chopr.png',
        ]);

        $question = Question::create([
            'image_id' => $image2->id,
            'text' => 'Click on the head.',
        ]);
        
        $slide = Slide::create([
            'image_id' => $image2->id,
            'question_id' => $question->id,
        ]);

        $options = Option::factory()
            ->count(4)
            ->sequence(
                ['label' => 'right answer'],
                ['label' => 'wrong answer 1'],
                ['label' => 'wrong answer 2'],
                ['label' => 'wrong answer 3'],
            )
            ->create();

        foreach ($options as $option) {
            SlideOption::create([
                'slide_id' => $slide->id,
                'option_id' => $option->id,
                'zone' => null,
                'is_correct' => $option->label === 'right answer',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

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

        $image = Image::create([
            'title' => 'this is a placeholder',
            'path' => 'it is not really here',
        ]);

        $question = Question::create([
            'image_id' => $image->id,
            'text' => 'Click on the head.',
        ]);

        $options = Option::factory()
            ->count(4)
            ->sequence(
                ['label' => 'right answer'],
                ['label' => 'wrong answer 1'],
                ['label' => 'wrong answer 2'],
                ['label' => 'wrong answer 3'],
            )
            ->create([
                'zone' => null,
            ]);
        
        $slide = Slide::create([
            'image_id' => $image->id,
            'question_id' => $question->id,
        ]);

        foreach ($options as $option) {
            SlideOption::create([
                'slide_id' => $slide->id,
                'option_id' => $option->id,
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

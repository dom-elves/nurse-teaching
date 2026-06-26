<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Slide;
use App\Models\Question;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $slide_id
 * @property int $question_id
 * @property string $title
 * @property string $imagePath
 */
#[Fillable(['slide_id', 'question_id', 'label', 'is_correct'])]
class Option extends Model
{
    /**
     * Get the question for an option
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the slide for an option
     */
    public function slide(): BelongsToMany
    {
        return $this->belongsTo(Slide::class);
    }
}

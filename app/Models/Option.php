<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Image;
use App\Models\Question;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $image_id
 * @property int $question_id
 * @property string $label
 * @property bool $is_correct
 * @property json $zone
 */
#[Fillable(['image_id', 'question_id', 'label', 'is_correct', 'zone'])]
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
     * Get the image for an option
     */
    public function image(): BelongsToMany
    {
        return $this->belongsTo(Image::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Image;
use App\Models\Question;
use App\Models\SlideOption;

/**
 * @property int $id
 * @property int $image_id
 * @property int $question_id
 */
#[Fillable(['image_id', 'question_id'])]
class Slide extends Model
{
    /**
     * Get the image for a slide
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Get the question for a slide
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the options for a slide
     */
    public function slideOptions(): HasMany
    {
        return $this->hasMany(SlideOption::class);
    }
}

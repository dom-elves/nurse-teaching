<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\Models\Slide;

/**
 * @property int $id
 * @property int $slide_id
 * @property int $question_id
 * @property string $label
 * @property bool $is_correct
 * @property json $zone
 */
class Question extends Model
{
    /**
     * Get the options for a question
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Get the slide for a question
     */
    public function slide(): BelongsToMany
    {
        return $this->hasMany(Slide::class);
    }
}

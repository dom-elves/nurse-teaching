<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Option;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $slide_id
 * @property string $text
 */
#[Fillable(['slide_id', 'text'])]
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
    public function slide(): BelongsTo
    {
        return $this->BelongsTo(Slide::class);
    }
}

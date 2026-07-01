<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Option;
use App\Models\image;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $image_id
 * @property string $text
 */
#[Fillable(['image_id', 'text'])]
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
     * Get the image for a question
     */
    public function image(): BelongsTo
    {
        return $this->BelongsTo(Image::class);
    }
}

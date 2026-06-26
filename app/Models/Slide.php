<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Quetsion;
use App\Models\Option;

/**
 * @property int $id
 * @property string $title
 * @property string $imagePath
 */
#[Fillable(['title', 'image_path'])]
class Slide extends Model
{
    use HasFactory;

    /**
     * Get the slide's available questions.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the slide's available options.
     */
    public function options(): HasManyThrough
    {
        return $this->hasMany(Option::class, Question::class);
    }
}

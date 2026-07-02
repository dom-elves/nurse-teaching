<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Slide;

/**
 * @property int $id
 * @property string $title
 * @property string $path
 */
#[Fillable(['title', 'path'])]
class Image extends Model
{
    use HasFactory;

    /**
     * Get the image's available slide.
     */
    public function slide(): HasMany
    {
        return $this->hasMany(Slide::class);
    }
}

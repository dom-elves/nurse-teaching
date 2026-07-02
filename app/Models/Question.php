<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $text
 */
#[Fillable(['text'])]
class Question extends Model
{
    /**
     * Get the Slide for a question
     */
    public function slide(): hasMany
    {
        return $this->hasMany(Slide::class);
    }
}

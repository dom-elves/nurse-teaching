<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SlideOption;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $label
 * @property json $zone
 */
#[Fillable(['label', 'zone'])]
class Option extends Model
{
    use HasFactory;
    
    /**
     * Get the SlideOptions for an option
     */
    public function slideOptions(): HasMany
    {
        return $this->hasMany(SlideOption::class);
    }
}

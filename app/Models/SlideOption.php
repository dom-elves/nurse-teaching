<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Slide;
use App\Models\Option;

/**
 * @property int $id
 * @property int $slide_id
 * @property int $option_id
 * @property bool $is_correct
 */
#[Fillable(['slide_id', 'option_id', 'is_correct'])]
class SlideOption extends Model
{
    public function slide(): BelongsTo
    {
        return $this->belongsTo(Slide::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}

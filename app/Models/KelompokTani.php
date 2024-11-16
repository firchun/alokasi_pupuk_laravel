<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KelompokTani extends Model
{
    use HasFactory;
    protected $table = 'kelompok_tani';
    protected $guarded = [];

    public function poktan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_poktan');
    }
}

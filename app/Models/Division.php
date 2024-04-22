<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'stream_id',
        'name',
    ];

    public function stream(): BelongsTo
    {
        return $this->belongsTo(Stream::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}

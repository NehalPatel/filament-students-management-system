<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','short_name'
    ];

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class, 'stream_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'stream_id');
    }
}

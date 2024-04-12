<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'stream_id',
        'name',
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}

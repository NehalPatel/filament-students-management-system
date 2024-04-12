<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guard = 'student';

    protected $fillable = [
        'stream_id',
        'division_id',
        'name',
        'email',
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}

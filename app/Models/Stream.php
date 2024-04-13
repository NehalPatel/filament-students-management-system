<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','short_name'
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class, 'stream_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'stream_id');
    }
}

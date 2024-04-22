<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected string $guard = 'student';

    // protected $fillable = [
    //     'stream_id',
    //     'division_id',
    //     'name',
    //     'email',
    //     'password',
    //     'mobile',
    //     'spdid',
    //     'enrollment_no'
    // ];

    protected $guarded = ['id'];

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

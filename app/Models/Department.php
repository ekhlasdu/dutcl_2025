<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'name',
    ];

    // Relationship: a PlayDetail belongs to a User
    public function user()
    {
        return $this->belongsTo(Department::class);
    }
}

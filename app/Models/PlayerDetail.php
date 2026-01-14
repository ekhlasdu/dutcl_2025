<?php

// app/Models/PlayDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerDetail extends Model
{
    use HasFactory;

    protected $table = 'player_details';

    protected $fillable = [
        'user_id',
        'profile_image',
        'department',
        'designation',
        'batting',
        'bowling',
        'keeping',
        'played_as_student',
        'played_dutcl',
        'ptype',
        // maybe add a column to mark category (pool/non‑pool) if not present
        'category', // e.g. 'pool' or 'non‑pool'
        'availability',
        'unavailability',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auction()
    {
        return $this->hasOne(Auction::class, 'player_detail_id');
    }
}


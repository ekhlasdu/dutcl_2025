<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'player_detail_id',
        'team_id',
        'amount',
    ];

    public function playerDetail()
    {
        return $this->belongsTo(PlayerDetail::class, 'player_detail_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function auctions()
    {
        return $this->hasMany(\App\Models\Auction::class);
    }
}

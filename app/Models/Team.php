<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function players()
    {
        return $this->hasManyThrough(
            PlayDetail::class,
            Auction::class,
            'team_id',       // foreign key on auctions table
            'user_id',       // foreign key on player_details table
            'id',            // local key on teams table
            'player_detail_id' // local key on auctions table
        );
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Auction;
use App\Models\Team;

class HomeController extends Controller
{
    public function player_list()
    {
        $players = PlayerDetail::with('user')->get();
        $user = Auth::user();

        return view('player-detail.player_list', compact('players','user'));
    }

    public function team_detail($id)
    {
        $team = Team::findOrFail($id);

        // Get all players bought by this team through the auctions table
        $players = Auction::with(['playerDetail.user'])
            ->where('team_id', $team->id)
            ->orderBy('amount', 'desc')
            ->get();

        $user = Auth::user();

        return view('player-detail.team_details', compact('team', 'players','user','id'));
    }
}

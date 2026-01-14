<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function listPlayers()
    {
        $players = PlayerDetail::with('user')->get();
        $user = Auth::user();

        return view('player-detail.player_list', compact('players','user'));
    }
}

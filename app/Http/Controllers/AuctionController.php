<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerDetail;
use App\Models\Auction;
use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Auth;

class AuctionController extends Controller
{
    /**
     * Show the auction page for a given category and player.
     */

    public function __construct()
    {
        
    }
    public function operateAuction($category, $playerId = null)
    {

        if ( Auth::user()->email !='admin_user@admin.com' ) {
            return redirect()->back(); 
        }

        $players = PlayerDetail::where('ptype', $category)
        ->whereDoesntHave('auction')
        ->orderBy('id')
        ->get();

        if ($players->isEmpty()) {
            return redirect()->back()->with('error', 'No available players for auction.');
        }

        // Determine current player
        $player = $playerId
            ? $players->where('id', $playerId)->first() ?? $players->first()
            : $players->first();

        // Determine previous and next player
        $currentIndex = $players->search(fn($p) => $p->id === $player->id);
        $previous = $players->get($currentIndex - 1);
        $next = $players->get($currentIndex + 1);
        
        $teams = Team::all();
        $basePrice = $category === 'pool' ? 3000 : 1000;

        // Total team budget - example, this could be from config or DB
        $totalBudget = 50000;

        $totalBudget = 50000;
        $poolBasePrice = 3000;
        $nonPoolBasePrice = 1000;
        $requiredPoolPlayers = 4;
        $requiredNonPoolPlayers = 11;

        $teamSummaries = [];

        foreach ($teams as $team) {
            // Count how many pool and non-pool players already bought by this team
            $poolPlayersCount = Auction::where('team_id', $team->id)
                ->whereHas('playerDetail', fn($q) => $q->where('ptype', 'Pool'))
                ->count();

            $nonPoolPlayersCount = Auction::where('team_id', $team->id)
                ->whereHas('playerDetail', fn($q) => $q->where('ptype', 'Non-Pool'))
                ->count();

            // Total spent on pool and non-pool players
            $poolSpent = Auction::where('team_id', $team->id)
                ->whereHas('playerDetail', fn($q) => $q->where('ptype', 'Pool'))
                ->sum('amount');

            $nonPoolSpent = Auction::where('team_id', $team->id)
                ->whereHas('playerDetail', fn($q) => $q->where('ptype', 'Non-Pool'))
                ->sum('amount');

            // Remaining players to buy
            $poolPlayersLeft = max(0, $requiredPoolPlayers - $poolPlayersCount);
            $nonPoolPlayersLeft = max(0, $requiredNonPoolPlayers - $nonPoolPlayersCount);

            // Calculate max bid for next pool player
            // - subtract spent on non-pool players
            // - subtract minimum cost of remaining pool players excluding next one (that's why -1)

            // $maxPoolBid = 0;
            // if ($poolPlayersLeft > 0) {
            //     $maxPoolBid = max(
            //         0,
            //         $totalBudget - $nonPoolSpent - ($poolPlayersLeft - 1) * $poolBasePrice
            //     );
            // }

            $maxPoolBid = $totalBudget- $poolSpent - $nonPoolSpent - ($poolPlayersLeft - 1) * $poolBasePrice - ($nonPoolPlayersLeft * $nonPoolBasePrice);
            $maxNonPoolBid = $totalBudget - $poolSpent - $nonPoolSpent - ($poolPlayersLeft * $poolBasePrice) - ($nonPoolPlayersLeft - 1) * $nonPoolBasePrice;

            // Calculate max bid for next non-pool player
            // if ($nonPoolPlayersLeft > 0) {
            //     $maxNonPoolBid = max(
            //         0,
            //         $totalBudget - $poolSpent - ($nonPoolPlayersLeft - 1) * $nonPoolBasePrice
            //     );
            // } else {
            //     $maxNonPoolBid = 0;
            // }

            $remainingAmount = max(0, $totalBudget - ($poolSpent + $nonPoolSpent));

            $teamSummaries[] = [
                'team_id' => $team->id,
                'team_name' => $team->name,
                'pool_players' => $poolPlayersCount,
                'non_pool_players' => $nonPoolPlayersCount,
                'max_pool_bid' => $maxPoolBid,
                'max_non_pool_bid' => $maxNonPoolBid,
                'remaining_amount' => $remainingAmount,
            ];
        }

        $user = Auth::user();

        // Pass variables to view
        return view('auctions.show', compact('player', 'category', 'teams', 'basePrice', 'teamSummaries','previous', 'next','user'));
    }

    /**
     * Store a new auction bid.
     */
    public function store(Request $request)
    {
        if ( Auth::user()->email !='admin_user@admin.com' ) {
            return redirect()->back(); 
        }

        $validated = $request->validate([
            'player_detail_id' => 'required|exists:player_details,id',
            'team_id' => 'required|exists:teams,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $player = PlayerDetail::findOrFail($validated['player_detail_id']);
        $team = Team::findOrFail($validated['team_id']);
        $category = $player->ptype;

        // ✅ Check if player already auctioned
        if (Auction::where('player_detail_id', $player->id)->exists()) {
            return back()->with('error', 'This player has already been auctioned.');
        }

        // ✅ Base price validation
        $basePrice = $category === 'pool' ? 3000 : 1000;
        if ($validated['amount'] < $basePrice) {
            return back()->with('error', "Bid must be at least base price of {$basePrice}.");
        }

        // ✅ Team total spent
        $totalSpent = Auction::where('team_id', $team->id)->sum('amount');
        $remainingBudget = 50000 - $totalSpent;

        if ($validated['amount'] > $remainingBudget) {
            return back()->with('error', 'Bid exceeds team’s remaining budget.');
        }

        // ✅ Check category-specific player count
        $categoryCount = Auction::where('team_id', $team->id)
            ->whereHas('playerDetail', function ($q) use ($category) {
                $q->where('ptype', $category);
            })->count();

        $limit = $category === 'pool' ? 4 : 11;

        if ($categoryCount >= $limit) {
            return back()->with('error', "Team already has max {$limit} {$category} players.");
        }

        // ✅ Predict future spending capacity
        $remainingAfterThisBid = $remainingBudget - $validated['amount'];
        $remainingPoolSlots = 4 - Auction::where('team_id', $team->id)
            ->whereHas('playerDetail', fn($q) => $q->where('ptype', 'pool'))->count();
        $remainingNonPoolSlots = 11 - Auction::where('team_id', $team->id)
            ->whereHas('playerDetail', fn($q) => $q->where('ptype', 'non-pool'))->count();

        $neededSlots = $remainingPoolSlots + $remainingNonPoolSlots - 1; // excluding current bid
        $minRequiredFuture = ($remainingPoolSlots * 3000) + ($remainingNonPoolSlots * 1000);

        if ($remainingAfterThisBid < $minRequiredFuture && $neededSlots > 0) {
            return back()->with('error', "This bid leaves insufficient budget to complete your team.");
        }

        // ✅ Store Auction
        Auction::create($validated);

        return back()->with('success', 'Player successfully auctioned!');
    }


     public function teamPlayer($id)
    {
        $team = Team::findOrFail($id);

        // Get all players bought by this team through the auctions table
        $players = Auction::with(['playerDetail.user'])
            ->where('team_id', $team->id)
            ->orderBy('amount', 'desc')
            ->get();

        $user = Auth::user();

        return view('auctions.team-players', compact('team', 'players','user'));
    }


    /**
     * List all unsold players with option to assign to a team for free.
     */
    public function unsoldPlayers()
    {
        if ( Auth::user()->email !='admin_user@admin.com' ) {
            return redirect()->back(); 
        }

        $unsold = PlayerDetail::with('user')
            ->whereDoesntHave('auction')
            ->get();

        $teams = Team::all();

        $user = Auth::user();

        return view('auctions.unsold', compact('unsold', 'teams','user'));
    }

    /**
     * Assign an unsold player to a team for free (amount = 0) without budget or player limit checks.
     */
    public function assignFree(Request $request)
    {
        if ( Auth::user()->email !='admin_user@admin.com' ) {
            return redirect()->back(); 
        }

        $validated = $request->validate([
            'player_detail_id' => 'required|exists:player_details,id',
            'team_id' => 'required|exists:teams,id',
        ]);

        $player = PlayerDetail::findOrFail($validated['player_detail_id']);

        // Check if player already auctioned/assigned
        if (Auction::where('player_detail_id', $player->id)->exists()) {
            return back()->with('error', 'This player has already been assigned.');
        }

        // Store assignment with amount = 0
        Auction::create([
            'player_detail_id' => $validated['player_detail_id'],
            'team_id' => $validated['team_id'],
            'amount' => 0,
        ]);

        return back()->with('success', 'Player assigned for free successfully!');
    }


    public function soldPlayers()
    {
        if ( Auth::user()->email !='admin_user@admin.com' ) {
            return redirect()->back(); 
        }

        $sold = PlayerDetail::with('user')
            ->whereHas('auction')
            ->get();

        $teams = Team::all();

        $user = Auth::user();

        return view('auctions.sold', compact('sold', 'teams','user'));
    }

    public function make_unsold($player_detail_id)
    {
        if ( Auth::user()->email !='admin_user@admin.com' ) {
            return redirect()->back(); 
        }

        Auction::where('player_detail_id', $player_detail_id)->delete();
        return back()->with('success', 'Player unsold successfully!');
    }


    
}

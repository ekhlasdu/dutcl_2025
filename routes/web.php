<?php

use App\Http\Controllers\PlayerDetailController;
use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/player_list', [HomeController::class, 'player_list']);
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [PlayerDetailController::class, 'index']);
    Route::post('/dashboard_update', [PlayerDetailController::class, 'dashboard_update']);

    Route::get('player/remove-image', [PlayerDetailController::class, 'removeImage'])->name('player.removeImage');

    // Add these routes to your routes/web.php file



// ... (existing routes)

    Route::get('/players', [PlayerDetailController::class, 'listPlayers'])->name('players.list');
    Route::post('/players/{id}/update-ptype', [PlayerDetailController::class, 'updatePtype'])->name('players.update-ptype');


    Route::get('/operateAuction/{category}/{playerId?}', [AuctionController::class, 'operateAuction']);
    Route::post('/auction/store', [AuctionController::class, 'store']);

    Route::get('/teamPlayer/{id}', [AuctionController::class, 'teamPlayer']);

    Route::get('/unsold-players', [AuctionController::class, 'unsoldPlayers'])->name('auction.unsold');
    Route::post('/assign-free', [AuctionController::class, 'assignFree'])->name('auction.assign-free');

    Route::get('/sold-players', [AuctionController::class, 'soldPlayers'])->name('auction.sold');
    Route::get('/make-unsold/{player_detail_id}', [AuctionController::class, 'make_unsold'])->name('auction.make-unsold');
});

require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerDetail;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PlayerDetailController extends Controller
{
    public function index()
    {

        // $departments = [
        //     'Computer Science and Engineering',
        //     'Electrical and Electronic Engineering',
        //     'Information Technology',
        //     'Software Engineering',
        //     'Mathematics',
        //     'Physics',
        //     'Chemistry',
        //     'Business Administration',
        //     'Economics',
        //     'English',
        //     'Statistics',
        //     'Civil Engineering',
        //     'Mechanical Engineering',
        //     'Pharmacy',
        //     'Public Administration'
        // ];

        // for ($i = 1; $i < 50; $i++) {

        //     PlayerDetail::create([
        //         'user_id'           => $i,
        //         'department'        => $departments[], // You can change this to a random list
        //         'designation'       => collect(['Lecturer', 'Assistant Professor', 'Associate Professor', 'Professor'])->random(),
        //         'batting'           => collect(['Just for Fun', 'Good', 'Excellent'])->random(),
        //         'bowling'           => collect(['Just for Fun', 'Good', 'Excellent'])->random(),
        //         'keeping'           => collect(['Just for Fun', 'Good', 'Excellent'])->random(),
        //         'played_as_student' => collect(['Yes', 'No'])->random(),
        //         'played_dutcl'      => collect(['Yes', 'No'])->random(),
        //         'ptype'             => collect(['Pool', 'Non-Pool'])->random(),
        //     ]);

        //     User::create([
        //         'name'              => 'User ' . $i,
        //         'email'             => 'user' . $i . '@example.com',
        //         'email_verified_at' => now(),
        //         'password'          => Hash::make('12345678'), // Hashed password
        //         'remember_token'    => 'token'.$i
        //     ]);
        // }

        $user = Auth::user();

        // Fetch existing player details or create new
        $playDetail = PlayerDetail::firstOrNew(['user_id' => $user->id]);
        $departments = Department::pluck('name', 'id');

        return view('player-detail.edit', compact('playDetail', 'departments','user'));
    }

    public function dashboard_update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'department' => 'required',
            'designation' => 'required',
            'batting' => 'nullable|in:Just for Fun,Good,Excellent',
            'bowling' => 'nullable|in:Just for Fun,Good,Excellent',
            'keeping' => 'nullable|in:Just for Fun,Good,Excellent',
            'played_as_student' => 'required|in:Yes,No',
            'played_dutcl' => 'required|in:Yes,No',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'availability' => 'nullable',
            'unavailability' => 'nullable',

            
        ]);

        $data['user_id'] = $user->id;

        // Retrieve or create player record
        $playDetail = PlayerDetail::firstOrNew(['user_id' => $user->id]);

        // ✅ Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($playDetail->profile_image && Storage::disk('public')->exists($playDetail->profile_image)) {
                Storage::disk('public')->delete($playDetail->profile_image);
            }

            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_images', $filename, 'public');

            $data['profile_image'] = $path;
        }

        $playDetail->fill($data)->save();

        return redirect('dashboard')->with('success', 'Your play details have been updated successfully.');
    }

    public function removeImage()
    {
        $user = Auth::user();
        $playDetail = PlayerDetail::where('user_id', $user->id)->first();

        if ($playDetail && $playDetail->profile_image && Storage::disk('public')->exists($playDetail->profile_image)) {
            Storage::disk('public')->delete($playDetail->profile_image);
            $playDetail->update(['profile_image' => null]);
        }

        return back()->with('success', 'Profile image removed successfully.');
    }

    public function listPlayers()
    {
        $players = PlayerDetail::with('user')->get();
        $user = Auth::user();

        return view('player-detail.list', compact('players','user'));
    }

    /**
     * Update the ptype of a player.
     */
    public function updatePtype(Request $request, $id)
    {
        if ( Auth::user()->email !='admin_user@admin.com' ) {
            return redirect()->back(); 
        }

        $validated = $request->validate([
            'ptype' => 'required|in:Pool,Non-Pool',
        ]);

        $player = PlayerDetail::findOrFail($id);
        $player->update(['ptype' => $validated['ptype']]);

        return redirect()->route('players.list')->with('success', 'Player type updated successfully.');
    }
}

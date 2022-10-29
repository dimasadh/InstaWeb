<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index($user)
    {
        $user = User::findOrFail($user);
        $followStatus = ((auth()->user()) ? auth()->user()->following->contains($user->id) : false);
        $followingCount = $user->following->count();
        $followersCount = $user->profile->followers->count();

        return view('profiles.index', [
            'user' => $user,
            'followStatus' => $followStatus,
            'followingCount' => $followingCount,
            'followersCount' => $followersCount
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);
        
        if (request('image'))
        {
            $imagePath = request('image') -> store('profile', 'public');

            $image = Image::make($request->file('image'))->fit(1200,1200);
            $image->save(public_path("storage/{$imagePath}"));

            $imageArray = ['image' => $imagePath];
        }

        $user->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
    }

}

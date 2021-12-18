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
        $posts = Post::where('user_id', $user->id)->OrderBy('created_at', 'DESC')->get();

        return view('profiles.index', [
            'user' => $user,
        ]);


        // $user = User::findOrFail($user);
        
        // return view('profiles.index', [
        //     'user' => $user,
        // ]);
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

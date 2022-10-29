<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        $users->push(strval(auth()->user()->id));
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
        
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image') -> store('uploads', 'public');

        $image = Image::make($request->file('image'))->fit(1200, 1200);
        $image->save(public_path("storage/{$imagePath}"));
        Post::create([
            'caption' => $data['caption'],
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect('/profile/' .auth()->user()->id);
    }

    public function show(\App\Models\Post $post)
    {
        return View::make('posts.show', compact('post'));
    }
}

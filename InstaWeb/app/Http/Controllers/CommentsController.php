<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function getComments(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->OrderBy('created_at', 'DESC')->get();
        
        return $comments;
    }

    public function store(Request $request, Post $post)
    {
        $data = request()->validate([
            'comment' => 'required',
        ]);

        $post = Post::find($post->id);
        if($post){
            Comment::create([
                'comment' => $data['comment'],
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);
    
            return Redirect::back()->with('message','Operation Successful!');
        }
        else{
            return Redirect::back()->with('message','Something was wrong!');
        }

    }

    public function delete(Comment $comment){
        $this->authorize('delete', $comment);

        $comment = Comment::find($comment->id);
        if($comment){
            $destroy = Comment::destroy($comment->id);
            if ($destroy){
                return Redirect::back()->with('message','Operation Successful!');
        
            }else{
                return Redirect::back()->with('message','Operation Failed!');
            
            }
        }
        else{
            return Redirect::back()->with('message','Something was wrong!');
        }

    }
}

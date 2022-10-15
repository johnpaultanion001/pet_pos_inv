<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        Comment::create(
            [
                'user_id'                   => auth()->user()->id,
                'post_id'                 => $request->input('post_id'),
                'comment'                    => $request->input('comment'),
            ]
        );

        $comments = Comment::where('post_id', $request->input('post_id'))
                            ->latest()
                            ->get();

        foreach($comments as $comment){
            $comments1[] = array(
                'name'              => $comment->user->name, 
                'comment'            => $comment->comment,
                'date_time'         => $comment->created_at->diffForHumans(),
            );
        }
        
        return response()->json([
            'comments'  => $comments1,
            'post_id'  => $request->input('post_id'),
            'comment_counts'  => $comments->count(),
        ]);
    }
}

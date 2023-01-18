<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use File;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('customer.posts' , compact('posts'));
    }

    public function store(Request $request)
    {
        $image = $request->file('image_post');
        $extension = $image->getClientOriginalExtension(); 
        $file_name_to_save = time().auth()->user()->name."_".auth()->user()->id.".".$extension;
        $image->move('customer/post/', $file_name_to_save);

        Post::create([
            'user_id'   => auth()->user()->id,
            'post' => $request->input('post'),
            'image' => $file_name_to_save ?? '',
        ]);

        return response()->json(['success' => 'Successfully posted']);
    }

    public function destroy(Post $post){
        $post->delete();
        return response()->json(['success' =>  'Removed Successfully.']);
    }

}

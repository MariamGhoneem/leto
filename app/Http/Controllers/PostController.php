<?php

namespace App\Http\Controllers;

use App\Models\Plike;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
Use Exception;

class PostController extends Controller
{
    //add post
    public function insert(Request $request, $user_id)
    {
        $rules = array(
            'content' => 'required',
            'title' => 'required'
        );

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()) {
            return response()->json([$validated->errors()],400);
        }
        else{
            $post = new Post();
            $post -> title      = $request-> title;
            $post -> content    = $request-> content;
            $post -> owner_id   = $user_id;
            $post -> cat_id     = $request -> cat_id;
            $post -> created_at = Carbon::now();
            try {
                $post ->save();
                return response()->json(['Post added successfully'=>$post]);
            } catch ( Exception $th) {
                return response()->json('error',406);
            }
        }
    }

    //get category posts
    public function catposts($cat_id)
    {
        $posts = Post::where('cat_id', '=',$cat_id)->with('user')->with('plikes')->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($posts);
    }

    //get user posts
    public function userposts($user_id)
    {
        $posts = Post::where('owner_id', '=',$user_id)->with('user')->with('plikes')->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($posts);
        
    }

    //view post
    public function show($user_id, $post_id)
    {
        if ($post = Post::find($post_id)) {
            $user = User::find($user_id);
            if (Plike::select('id')->where('liker_id', '=', $user_id)->where('post_id', '=', $post_id)->value('id')) {
                return response()->json(['username' => $user-> name,'liked' => 'True','post' => $post]);
            } else {
                return response()->json(['username' => $user-> name,'liked' => 'False','post' => $post]);
            }
        } else{
            return response()->json('Not found',404);
        }
        
        
    }

    //like post
    public function plike($user_id, $post_id)
    {
        if (Plike::select('id')->where('liker_id', '=', $user_id)->where('post_id', '=', $post_id)->value('id')) {
            return response()->json('already liked',409);
        } else {
            $plike = new Plike();
            $plike -> liker_id = $user_id;
            $plike -> post_id = $post_id;
            $plike -> save();

            $lnums = Post::select('lnums')->where('id', '=', $post_id)->value('lnums') +1;
            $post = Post::find($post_id);
            $post -> lnums = $lnums;
            $post->save();
            return response()->json('liked');
        }
    }

    //unlike post
    public function punlike($user_id, $post_id)
    {
        if ($id = Plike::select('id')->where('liker_id', '=', $user_id)->where('post_id', '=', $post_id)->value('id')) {
            $like = Plike::find($id);
            $like -> delete();
            $lnums = Post::select('lnums')->where('id', '=', $post_id)->value('lnums') -1;
            $post = Post::find($post_id);
            $post -> lnums = $lnums;
            $post -> save();
            return response()->json('unliked');
        } else {
            return response()->json('not liked',404);
        }
    }

    //edit post
    public function edit(Request $request, $usrt_id,$post_id)
    {
        if ($post =Post::where('id','=',$post_id)->where('owner_id','=',$usrt_id)->first()) {
            $post -> title      = $request-> title;
            $post -> content    = $request-> content;
            $post->save();
            return response()->json($post);
        }  else{
            return response()->json('Unauthorized',401);
        }      
    }

    //delete post
    public function delete($usrt_id,$post_id)
    {
        if ($post =Post::where('id','=',$post_id)->where('owner_id','=',$usrt_id)->first()) {
            $post->delete();
            return response()->json(["post deleted successfully"]);
        } else {
            return response()->json('Unauthorized',401);   
        }
    }
}

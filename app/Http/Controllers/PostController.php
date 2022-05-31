<?php

namespace App\Http\Controllers;

use App\Models\Plike;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
Use Exception;

class PostController extends Controller
{
    //add post
    //finished
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
        //To-Do: return liked or not //mainly done
        //To-Do return correct date format
        $posts = Post::where('cat_id', '=',$cat_id)->with('user')->with('plikes')->orderBy('created_at', 'desc')->get()->makeHidden(['owner_id','cat_id']);
        return response()->json($posts);
    }

    //view post
    //finished
    public function show($user_id, $post_id)
    {
        $post = Post::find($post_id);
        $user = User::find($user_id);
        $date = $post->created_at->format('d/m/Y');
        if (Plike::select('id')->where('liker_id', '=', $user_id)->where('post_id', '=', $post_id)->value('id')) {
            return response()->json(['post'=>$post,'username' => $user-> name, 'date' => $date,'liked' => 'True']);
        } else {
            return response()->json(['post'=>$post,'username' => $user-> name,'date' => $date,'liked' => 'False']);
        }
    }

    //like post
    //finished
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
    //finished
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

    //get user posts
    public function userposts($user_id)
    {
        //To-Do return correct date format
        if ($posts = Post::where('owner_id', '=',$user_id)->get()) {
            //$date = $posts->created_at->format('d/m/Y');
            return response()->json($posts);
        } else {
            return response()->json('no posts found',404);
        }
    }
}

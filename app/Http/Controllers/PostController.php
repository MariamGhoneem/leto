<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plike;
use App\Models\Post;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
Use Exception;

class PostController extends Controller
{
    //add post
    public function insert(Request $request, $user_id)
    {
        $rules = array(
            'content' => 'required'
        );

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()) {
            return $validated->errors();
        }
        else{
            $post = new Post();
            $post -> content =  $request->content;
            $post -> owner_id = $user_id;
            $post -> cat_id =   $request -> cat_id;
            try {
                $post ->save();
                return response()->json('Post added successfully');
            } catch ( Exception $th) {
                return response()->json('error');
            }
        }
    }

    //view post
    public function show($user_id, $post_id)
    {
        $post = Post::find($post_id);
        if (Plike::select('id')->where('liker_id', '=', $user_id)->where('post_id', '=', $post_id)->value('id')) {
            return response()->json(['post'=>$post,'liked'=>'True']);
        } else {
            return response()->json(['post'=>$post,'liked'=>'False']);
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

    //get user posts
    public function userposts($user_id)
    {
        if ($posts = Post::where('owner_id', '=',$user_id)->get()) {
            return response()->json($posts);
        } else {
            return response()->json('no posts found',404);
        }
    }

    //get all categories
    public function cats()
    {
        $cats = Category::get();
        return response()->json($cats);
    }

    //get category posts
    public function catposts($cat_id)
    {
        //To-Do: return liked or not

        if ($posts = Post::where('cat_id', '=',$cat_id)->get()) {
            return response()->json($posts);
        } else {
            return response()->json('no posts found',404);
        }
    }
}

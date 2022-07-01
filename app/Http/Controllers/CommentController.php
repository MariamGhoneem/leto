<?php

namespace App\Http\Controllers;

use App\Models\Clike;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
Use Exception;

class CommentController extends Controller
{
    //add comment
    public function insert(Request $request, $user_id, $post_id)
    {
        $rules = array(
            'content' => 'required',
        );

        $validated = Validator::make($request->all(),$rules);
        if ($validated->fails()) {
            return response()->json([$validated->errors()],400);
        }
        else{
            $comment = new Comment();
            $comment -> content    = $request-> content;
            $comment -> owner_id   = $user_id;
            $comment -> post_id   = $post_id;
            $comment -> created_at = Carbon::now();
            try {
                $comment ->save();
                Post::select('cnums')->where('id', '=', $post_id)->increment('cnums');
                return response()->json(['comment added successfully'=>$comment]);
            } catch ( Exception $th) {
                return response()->json($th,406);
            }
        }
    }


    //like comment
    public function clike($user_id, $comment_id)
    {
        if (Clike::select('id')->where('liker_id', '=', $user_id)->where('comment_id', '=', $comment_id)->value('id')) {
            return response()->json('already liked',409);
        } else {
            $clike = new Clike();
            $clike -> liker_id = $user_id;
            $clike -> comment_id = $comment_id;
            $clike -> save();
            Comment::select('lnums')->where('id', '=', $comment_id)->increment('lnums');
            return response()->json('liked');
        }
    }

    //unlike comment
    public function cunlike($user_id, $comment_id)
    {
        if ($id = Clike::select('id')->where('liker_id', '=', $user_id)->where('comment_id', '=', $comment_id)->value('id')) {
            $like = Clike::find($id);
            $like -> delete();
            Comment::select('lnums')->where('id', '=', $comment_id)->decrement('lnums');
            return response()->json('unliked');
        } else {
            return response()->json('not liked',404);
        }
    }
    
    //edit comment
    public function edit(Request $request, $user_id,$comment_id)
    {
        if ($comment =Comment::where('id','=',$comment_id)->where('owner_id','=',$user_id)->first()) {
            $comment -> content      = $request-> content;
            $comment->save();
            return response()->json($comment);
        }  else{
            return response()->json('Unauthorized',401);
        }      
    }

    //delete comment
    public function delete($user_id,$post_id,$comment_id)
    {
        if ($comment =Comment::where('id','=',$comment_id)->where('owner_id','=',$user_id)->first()) {
            $comment->delete();
            Post::select('cnums')->where('id', '=', $post_id)->decrement('cnums');
            return response()->json(["comment deleted successfully"]);
        } else {
            return response()->json('Unauthorized',401);   
        }
    }
    
    //post comments 
    public function postcomments($post_id)
    {
        //To-Do: return liked or not
        $comments = Comment::where('post_id', '=',$post_id)->with('user')->with('clikes')->orderBy('created_at', 'desc')->get();
        return response()->json(['comments' => $comments]);
        
    }
}

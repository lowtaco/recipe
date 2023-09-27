<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function getComments(Request $request) {
        $post_id = $request->input('post_id');

        $comments = DB::table('comments')->where('post_id', $post_id)->orderBy('likes_amount', 'desc')->get();

        return $comments;
    }

    public function addComment(Request $request) {
        $is_reply = $request->input('is_reply');
        $post_id = $request->input('post_id');
        $author_id = $request->input('author_id');
        $body = $request->input('body');

        $id = DB::table('comments')->insertGetId([
            'is_reply' => $is_reply,
            'post_id' => $post_id,
            'author_id' => $author_id,
            'body' => $body,
        ]);

        return $id;
    }

    public function addReply(Request $request) {
        $is_reply = $request->input('is_reply');
        $post_id = $request->input('post_id');
        $author_id = $request->input('author_id');
        $body = $request->input('body');

        $replies_amount = DB::table('comments')->where('id', $post_id)->value('replies_amount');

        $id = DB::table('comments')->insertGetId([
            'is_reply' => $is_reply,
            'post_id' => $post_id,
            'author_id' => $author_id,
            'body' => $body,
        ]);

        DB::table('comments')->where('id', $post_id)->update(['replies_amount' => $replies_amount + 1]);

        return $id;
    }
    
}

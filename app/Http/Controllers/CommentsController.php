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
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function authorize(Request $request) {
        $email = $request->input('email');
        $user = DB::table('app_users')->where('email', $email)->get();
        return $user;
    }

    public function registerUser(Request $request) {
        $email = $request->input('email');
        $nickname = $request->input('nickname');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $picture = $request->input('picture');

        $id = DB::table('app_users')->insertGetId([
            'email' => $email,
            'nickname' => $nickname,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'picture' => $picture
        ]);

        return $id;
    }

    public function getUserInfo(Request $request) {
        $id = $request->input('id');

        $user = DB::table('app_users')->where('id', $id)->get();

        return $user;
    }
}

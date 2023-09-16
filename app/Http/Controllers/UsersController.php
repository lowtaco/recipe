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

        $id = DB::table('app_users')->insertGetId([
            'email' => $email,
            'nickname' => $nickname,
            'first_name' => $first_name,
            'last_name' => $last_name
        ]);

        return $id;
    }

    public function updateUserAvatar(Request $request) {
        $id = $request->input('user_id');
        $picture = $request->input('picture');
        DB::table('app_users')->where('id', $id)->update(['picture' => $picture]);
    }

    public function updateUserInfo(Request $request) {
        $user_id = $request->input('user_id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $nicakname = $request->input('nicakname');
        $bio = $request->input('bio');
        $site = $request->input('site');

        DB::table('app_users')->where('id', $user_id)->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'nickname' => $nicakname,
            'bio' => $bio,
            'site' => $site
        ]);
    }

    public function getUserInfo(Request $request) {
        $id = $request->input('id');

        $user = DB::table('app_users')->where('id', $id)->get();

        return $user;
    }

    public function findUserByNickname(Request $request) {
        $nickname = $request->input('nickname');

        $user = DB::table('app_users')->where('nickname', $nickname)->get();

        return $user;
    }
}

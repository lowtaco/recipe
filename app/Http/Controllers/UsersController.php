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

    public function checkSubscription(Request $request) {
        $profile_id = $request->input('profile_id');
        $subscriber_id = $request->input('subscriber_id');

        $subscriber_subscriptions = json_decode(DB::table('app_users')->where('id', $subscriber_id)->value('subscriptions'));
        $subsription = false;

        if ($subscriber_subscriptions != null) {
            if (in_array($profile_id, $subscriber_subscriptions)) {
                $subsription = true;
            }
        }

        return $subsription;
    }

    public function subscribeToUser(Request $request) {
        $profile_id = $request->input('profile_id');
        $subscriber_id = $request->input('subscriber_id');

        $profile_subscribers_amount = DB::table('app_users')->where('id', $profile_id)->value('subscribers_amount');
        $subscriber_subscription_amount = DB::table('app_users')->where('id', $subscriber_id)->value('subscriptions_amount');
        $profile_subscribers = json_decode(DB::table('app_users')->where('id', $profile_id)->value('subscribers'));
        $subscriber_subscriptions = json_decode(DB::table('app_users')->where('id', $subscriber_id)->value('subscriptions'));

        if ($profile_subscribers === null) {
            $profile_subscribers = array($subscriber_id);
            DB::table('app_users')->where('id', $profile_id)->update(['subscribers_amount' => 1]);
        } else {
            if (!in_array($subscriber_id, $profile_subscribers)) {
                array_push($profile_subscribers, $subscriber_id);
                DB::table('app_users')->where('id', $profile_id)->update(['subscribers_amount' => $profile_subscribers_amount + 1]);
            }
        }

        if($subscriber_subscriptions === null) {
            $subscriber_subscriptions = array(+$profile_id);
            DB::table('app_users')->where('id', $subscriber_id)->update(['subscriptions_amount' => 1]);
        } else {
            if (!in_array($profile_id, $subscriber_subscriptions)) {
                array_push($subscriber_subscriptions, +$profile_id);
                DB::table('app_users')->where('id', $subscriber_id)->update(['subscriptions_amount' => $subscriber_subscription_amount + 1]);
            }
        }
        DB::table('app_users')->where('id', $subscriber_id)->update(['subscriptions' => $subscriber_subscriptions]);
        DB::table('app_users')->where('id', $profile_id)->update(['subscribers' => $profile_subscribers]);

        return $profile_subscribers_amount + 1;
    }

    public function unsubscribeToUser(Request $request) {
        $profile_id = $request->input('profile_id');
        $subscriber_id = $request->input('subscriber_id');

        $profile_subscribers_amount = DB::table('app_users')->where('id', $profile_id)->value('subscribers_amount');
        $subscriber_subscription_amount = DB::table('app_users')->where('id', $subscriber_id)->value('subscriptions_amount');
        $profile_subscribers = json_decode(DB::table('app_users')->where('id', $profile_id)->value('subscribers'));
        $subscriber_subscriptions = json_decode(DB::table('app_users')->where('id', $subscriber_id)->value('subscriptions'));
        
        if ($profile_subscribers != null) {
            if (in_array($subscriber_id, $profile_subscribers)) {
                $subscriber_index = array_search($subscriber_id, $profile_subscribers);
                unset($profile_subscribers[$subscriber_index]);
                DB::table('app_users')->where('id', $profile_id)->update(['subscribers_amount' => $profile_subscribers_amount - 1]);
            }
        }

        if ($subscriber_subscriptions != null) {
            if (in_array($profile_id, $subscriber_subscriptions)) {
                $profile_index = array_search($profile_id, $subscriber_subscriptions);
                unset($subscriber_subscriptions[$profile_index]);
                DB::table('app_users')->where('id', $subscriber_id)->update(['subscriptions_amount' => $subscriber_subscription_amount - 1]);
            }
        } 
        DB::table('app_users')->where('id', $subscriber_id)->update(['subscriptions' => $subscriber_subscriptions]);
        DB::table('app_users')->where('id', $profile_id)->update(['subscribers' => $profile_subscribers]);

        return $profile_subscribers_amount - 1;
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ShoppingListsController extends Controller
{
    public function getUserLists(Request $request) {
        $user = $request->input('user');
        $shopping_lists = DB::table('shopping_lists')->where('owner', $user)->get();
        $shared_lists = DB::table('shopping_lists')->whereJsonContains('shared_users', $user)->where('shared', 1)->get();
        $lists = $shared_lists->merge($shopping_lists);
        return $lists;
    }

    public function getShoppingListByRecipe(Request $request) {
        $user = $request->input('user');
        $id = $request->input('id');

        $list = DB::table('shopping_lists')->where('owner', $user)->where('recipe_id', $id)->get();
        return $list;
    }

    public function createShoppingList(Request $request) {
        $name = $request->input('name');
        $color = $request->input('color');
        $icon = $request->input('icon');
        $owner = $request->input('user');
        $recipe_id = $request->input('recipe_id');
        $personal = $request->input('personal');
        $list = $request->input('list');
        $picture = $request->input('picture');
        $id = DB::table('shopping_lists')->insertGetId([
            'name' => $name,
            'owner' => $owner,
            'personal' => $personal,
            'recipe_id' => $recipe_id,
            'icon' => $icon,
            'picture' => $picture,
            'color' => $color,
            'list' => $list
        ]);
        return $id;
    }

    public function getListInfo(Request $request) {
        $id = $request->input('id');
        $shopping_list = DB::table('shopping_lists')->where('id', $id)->get();
        return $shopping_list;
    }

    public function updateList(Request $request) {
        $user = $request->input('user');
        $id = $request->input('id');
        $list = $request->input('list');
        DB::table('shopping_lists')->where('id', $id)->update(['list' => $list]);
        return $list;
    }

    public function updateListInfo(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $color = $request->input('color');
        $icon = $request->input('icon');
        DB::table('shopping_lists')->where('id', $id)->update(['name' => $name, 'color' => $color, 'icon' => $icon]);
    }

    public function deleteList(Request $request) {
        $id = $request->input('id');
        DB::table('shopping_lists')->where('id', $id)->delete();
    }

    public function inviteUserToList(Request $request) {
        $list_id = $request->input('list_id');
        $user_id = $request->input('user_id');
        $list_owner_id = $request->input('list_owner_id');

        $id = DB::table('pending_shared_shopping_list')->insertGetId([
            'list_id' => $list_id,
            'user_id' => $user_id,
            'list_owner_id' => $list_owner_id,
        ]);
        return $id;
    }

    public function findShareListPending(Request $request) {
        $list_id = $request->input('list_id');
        $user_id = $request->input('user_id');
        $list_owner_id = $request->input('list_owner_id');

        $pending = DB::table('pending_shared_shopping_list')->where('list_id', $list_id)->where('user_id', $user_id)->where('list_owner_id', $list_owner_id)->get();
        return $pending;
    }

    public function countSharedListsInvites(Request $request) {
        $user_id = $request->input('user_id');

        $count = DB::table('pending_shared_shopping_list')->where('user_id', $user_id)->count();
        return $count;
    }

    public function getShoppingListInvites(Request $request) {
        $user_id = $request->input('user_id');

        $invites = DB::table('pending_shared_shopping_list')->where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return $invites;
    }

    public function getSharedListStatus(Request $request) {
        $list_id = $request->input('list_id');

        $sharedStatus = DB::table('shopping_lists')->where('id', $list_id)->value('shared');
        return $sharedStatus;
    }

    public function updateSharedStatus(Request $request) {
        $list_id = $request->input('list_id');
        $status = $request->input('status');

        DB::table('shopping_lists')->where('id', $list_id)->update(['shared' => $status]);
    }

    public function declineInviteList(Request $request) {
        $invite_id = $request->input('invite_id');

        DB::table('pending_shared_shopping_list')->where('id', $invite_id)->delete();
    }

    public function aproveInviteList(Request $request) {
        $invite_id = $request->input('invite_id');
        $shared_users = $request->input('shared_users');

        $user_id = DB::table('pending_shared_shopping_list')->where('id', $invite_id)->value('user_id');
        $list_id = DB::table('pending_shared_shopping_list')->where('id', $invite_id)->value('list_id');

        DB::table('shopping_lists')->where('id', $list_id)->update(['shared_users' => $shared_users]);
        DB::table('pending_shared_shopping_list')->where('id', $invite_id)->delete();
    }

    public function getSharedShoppingListUsers(Request $request) {
        $list_id = $request->input('list_id');

        $shared_users = DB::table('shopping_lists')->where('id', $list_id)->value('shared_users');
        return json_decode($shared_users);
    }

    public function updateSharedUsers(Request $request) {
        $list_id = $request->input('list_id');
        $shared_users = $request->input('shared_users');

        DB::table('shopping_lists')->where('id', $list_id)->update(['shared_users' => $shared_users]);
    }
}

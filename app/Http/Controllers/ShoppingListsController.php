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
        $shared_lists = DB::table('shopping_lists')->whereJsonContains('shared_users', $user)->get();
        $lists = $shared_lists->merge($shopping_lists);
        return $lists;
    }

    public function createShoppingList(Request $request) {
        $name = $request->input('name');
        $color = $request->input('color');
        $icon = $request->input('icon');
        $owner = $request->input('user');
        $personal = 1;
        $list = json_encode([]);
        $shared = 0;
        $shared_users = json_encode([]);
        $id = DB::table('shopping_lists')->insertGetId([
            'name' => $name,
            'owner' => $owner,
            'personal' => $personal,
            'shared' => $shared,
            'shared_users' => $shared_users,
            'icon' => $icon,
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
}

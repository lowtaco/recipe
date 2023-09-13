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

    public function getShoppingListByName(Request $request) {
        $user = $request->input('user');
        $name = $request->input('name');

        $list = DB::table('shopping_lists')->where('owner', $user)->where('name', $name)->get();
        return $list;
    }

    public function createShoppingList(Request $request) {
        $name = $request->input('name');
        $color = $request->input('color');
        $icon = $request->input('icon');
        $owner = $request->input('user');
        $personal = $request->input('personal');
        $list = $request->input('list');
        $picture = $request->input('picture');
        $id = DB::table('shopping_lists')->insertGetId([
            'name' => $name,
            'owner' => $owner,
            'personal' => $personal,
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
}

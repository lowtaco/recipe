import { createRouter, createWebHashHistory } from 'vue-router';

import Debug from "./components/Debug";

import Splash from './components/splash_screen/splash_screen'

import Home from './components/pages/Home.vue'
import Ideas from "./components/pages/Ideas";
import ShoppingLists from "./components/pages/ShoppingLists";

import AddList from "./components/pages/shopping_list/AddList.vue"
import ListViewer from "./components/pages/shopping_list/ListViewer.vue"
import EditListViewer from "./components/pages/shopping_list/EditList"

import Account from "./components/pages/Account";

import AddRecipe from "./components/pages/recipe/AddRecipe";
import RecipeViewer from "./components/pages/recipe/RecipeViewer"

export default createRouter({
  history: createWebHashHistory(),
  routes: [
    // Menu
    {path: '/', component: Home},
    {path: '/ideas', component: Ideas},
    {path: '/shopping-lists', component: ShoppingLists},
    {path: '/account', component: Account},

    // Authorize
    {path: '/auth', component: Splash},

    // Recipes
    {path: '/add-recipe', component: AddRecipe},
    {path: '/recipe/:id', component: RecipeViewer, props: true},

    // Shopping Lists
    {path: '/add-list', component: AddList},
    {path: '/list/:id', component: ListViewer, props: true},
    {path: '/edit-list/:id', component: EditListViewer, props: true},

    {path: '/debug', component: Debug},
  ]
})
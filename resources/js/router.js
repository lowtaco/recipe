import { createRouter, createWebHashHistory } from 'vue-router';

import Debug from "./components/Debug";

import Splash from './components/splash_screen/splash_screen'

import Home from './components/pages/Home.vue'
import Ideas from "./components/pages/Ideas";
import ShoppingLists from "./components/pages/ShoppingLists";
import Account from "./components/pages/Account";

import AddRecipe from "./components/pages/recipe/AddRecipe";
import RecipeViewer from "./components/pages/recipe/RecipeViewer"

export default createRouter({
  history: createWebHashHistory(),
  routes: [
    {path: '/', component: Home},
    {path: '/ideas', component: Ideas},
    {path: '/shopping-lists', component: ShoppingLists},
    {path: '/account', component: Account},

    {path: '/auth', component: Splash},

    {path: '/add-recipe', component: AddRecipe},
    {path: '/recipe/:id', component: RecipeViewer, props: true},

    {path: '/debug', component: Debug},
  ]
})
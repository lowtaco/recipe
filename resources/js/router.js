import { createRouter, createWebHashHistory } from 'vue-router';

import Debug from "./components/Debug";

import Welcome from './components/splash_screen/welcome_screen'

import Home from './components/pages/Home.vue'
import Ideas from "./components/pages/Ideas";
import ShoppingLists from "./components/pages/ShoppingLists";

import AddList from "./components/pages/shopping_list/AddList.vue"
import ListViewer from "./components/pages/shopping_list/ListViewer.vue"
import EditListViewer from "./components/pages/shopping_list/EditList"
import SharedListViewer from "./components/pages/shopping_list/SharedListViewer"
import InvitesListViewer from "./components/pages/shopping_list/InvitesViewer"

import Account from "./components/pages/Account";
import AccountEditor from './components/pages/account/account_editor.vue';
import ProfileViewer from './components/pages/profile/ProfileViewer.vue';

import AddRecipe from "./components/pages/recipe/AddRecipe";
import RecipeViewer from "./components/pages/recipe/RecipeViewer"

import stories from "./components/core/stories_engine/stories.vue"

export default createRouter({
  history: createWebHashHistory(),
  routes: [
    // Menu
    {path: '/', component: Home},
    {path: '/ideas', component: Ideas},
    {path: '/shopping-lists', component: ShoppingLists},
    {path: '/account', component: Account},

    // Authorize
    {path: '/auth', component: Welcome},

    // Recipes
    {path: '/add-recipe', component: AddRecipe},
    {path: '/recipe/:id', component: RecipeViewer, props: true},

    // Shopping Lists
    {path: '/add-list', component: AddList},
    {path: '/list/:id', component: ListViewer, props: true},
    {path: '/edit-list/:id', component: EditListViewer, props: true},
    {path: '/shared-list/:token', component: SharedListViewer, props: true},
    {path: '/invites-list', component: InvitesListViewer},

    // Account
    {path: '/account-editor', component: AccountEditor},
    {path: '/profile/:profileID', component: ProfileViewer,  props: true},

    {path: '/stories', component: stories},

    {path: '/debug', component: Debug},
  ]
})
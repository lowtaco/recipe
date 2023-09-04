<template>
  <div class="food-app">
    <div class="main-content">
      <component 
      :is="page" 
      :logged="logged" 
      :user="user" 
      @hideMenu="hideMenu" 
      @debug="page = 'Debug'" 
      @addRecipe="page = 'AddRecipe'" 
      @goBackHome="page = 'Home'"
      />
    </div>

    <div class="mobile-menu" v-if="!isMenuHidden">
      <mobile-menu @handler="mobileMenuHandler" :current="page"/>
    </div>

    
  </div>
</template>

<script>

import MobileMenu from "./MobileMenu";

import Splash from './splash_screen/splash_screen'

import Home from "./pages/Home";
import Search from "./pages/Search";
import Ideas from "./pages/Ideas";
import ShoppingLists from "./pages/ShoppingLists";
import Account from "./pages/Account";
import Debug from "./Debug";
import Stories from "./core/stories/story_viewer"
import RecipeViewer from "./pages/recipe/RecipeViewer"

import AddRecipe from "./pages/recipe/AddRecipe";

export default {

  components: {
    'mobile-menu': MobileMenu,
    Home,
    Search,
    Ideas,
    ShoppingLists,
    Account,
    Debug,
    Stories,
    AddRecipe,
    RecipeViewer,
    Splash
  },

  data() {
    return {
      page: 'RecipeViewer',
      logged: false,
      user: null,
      isMenuHidden: false
    }
  },

  mounted() {
    //! Fix Mobile Chrome 100vh
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    window.addEventListener('resize', () => {
      let vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty('--vh', `${vh}px`);
    });

    //! Check authorization data
    let token = localStorage.getItem('token');
    let user = JSON.parse(localStorage.getItem('user'));
    if(token && user) {
      this.logged = true;
      this.user = user;
    } else {
      this.logged = false;
      this.page = 'Splash'
      this.isMenuHidden = true;
    }
    console.log("Авторизован:", this.logged)
  },
  methods: {
    mobileMenuHandler(page) {
      this.page = page;
    },
    hideMenu(value) {
      this.isMenuHidden = value;
    }
  }

};
</script>
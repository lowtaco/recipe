<template>
  
  <div class="food-app">
    <div class="main-content">
      <router-view :is="page" 
        :logged="logged" 
        :user="user"
        @hideMenu="hideMenu"
        @addRecipe="page = 'AddRecipe'"
        @goBackHome="page = 'Home'"
      />
    </div>

    <div class="mobile-menu" v-if="!isMenuHidden">
      <mobile-menu/>
    </div>

    
  </div>
</template>

<script>

//TODO: Запретить реадактирование списка покупок, если не ты его создатель
//TODO: Сделать общий доступ по ссылке


import MobileMenu from "./MobileMenu";

import Home from "./pages/Home";
import Search from "./pages/Search";

import AddRecipe from "./pages/recipe/AddRecipe";

export default {

  components: {
    'mobile-menu': MobileMenu,
    Home,
    Search,
    AddRecipe,
  },

  data() {
    return {
      page: 'RecipeViewer',
      logged: false,
      user: null,
      isMenuHidden: false
    }
  },

  async mounted() {
    //! Fix Mobile Chrome 100vh
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    window.addEventListener('resize', () => {
      let vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty('--vh', `${vh}px`);
    });

    //! Check authorization data
    await this.checkAuthorizationData();
  },
  methods: {
    mobileMenuHandler(page) {
      this.page = page;
    },
    hideMenu(value) {
      this.isMenuHidden = value;
    },

    checkAuthorizationData() {
      let token = localStorage.getItem('token');
      let user = JSON.parse(localStorage.getItem('user'));

      if(token && user) {
        this.logged = true;
        this.user = user;

        this.getUserInfo();

      } else {
        this.logged = false;
        this.$router.push('/auth');
        this.isMenuHidden = true;
      }
      console.log("Авторизован:", this.logged);

    },

    async getUserInfo() {
      try {
        const user = await axios.post('/get-user-info', {
          id: this.user.id
        });
        if(user.data[0]) {
          localStorage.setItem('user', JSON.stringify(user.data[0]));
        } 
      } catch (e) {
        console.log(e);
      }
    }, 
  }
};
</script>
<template>
  <div class="page no-padding" v-if="!isSettingsOpen">

    <div class="page-content" id="profile-scroll-box">
      <div class="profile" id="profile-reference">
        <div class="profile-top">
          <div class="header">
            <h1>Профиль</h1>
            <div class="header-buttons">
              <div class="item" @click="isSettingsOpen = true">
                <icon icon="settings"/>
              </div>
            </div>
          </div>

          <div class="main-info">
            <img :src="user.picture">
            <div class="name">
              <h1>{{ user.first_name }} {{ user.last_name }}</h1>
              <h4>@{{ user.nickname }}</h4>
            </div>
          </div>

          <div class="additional-info">
            <div class="item">
              <span>888k</span>
              <p>подписчики</p>
            </div>
            <div class="item">
              <span>198</span>
              <p>рецепты</p>
            </div>
          </div>
          <button>Редактировать</button>
        </div>
        <div class="profile-content">
          <h2>Рецепты</h2>
          <profile-folders-slider />
          <div class="posts">
            <div class="post" v-for="recipe in recipes">
              <img :src="recipe.main_banner_url">
            </div>

          </div>

        </div>
      </div>
    </div>

  </div>
  
  <div class="page p-settings" v-if="isSettingsOpen">
    <settings @goBack="isSettingsOpen = false" @debug="$emit('debug')"/>
  </div>

</template>
<script>

import Settings from './Settings';

import profile_folders_slider from '../core/elements/profile-folders-slider'

export default {
  props: ['logged', 'user'],
  
  components: {
    'settings': Settings,
    'profile-folders-slider': profile_folders_slider
  },

  data() {
    return {
      isSettingsOpen: false,
      recipes: [],
      scrollBox: null
    }
  },
  async mounted() {
    console.log(this.user);
    this.getRecipes();

    this.scrollBox = document.getElementById('profile-scroll-box')
    this.scrollBox.addEventListener("scroll", _.debounce(this.scrollHandler, 200))
  },
  unmounted() {
    this.scrollBox.removeEventListener("scroll", _.debounce(this.scrollHandler, 200))
  },
  methods: {
    async getRecipes(offset = 0) {
      axios.post('/get-recipes', {
        offset: offset
      }).then((response) => {
        this.recipes = this.recipes.concat(response.data) 
      })
    },

    scrollHandler() {
      let reference = document.getElementById('profile-reference')

      let scrollTop = Math.round(this.scrollBox.scrollTop);
      let rect = this.scrollBox.getBoundingClientRect();
      let viewportHeight = Math.round(rect.height);
      let totalHeight = reference.offsetHeight;

      let currentHeight = scrollTop + viewportHeight;

      if(currentHeight >= (totalHeight * 0.75)) {
        this.getRecipes(this.recipes.length)
      }
    }
  },
};
</script>
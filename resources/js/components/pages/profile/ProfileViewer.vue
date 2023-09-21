<template>
  <div class="page no-padding">

    <div class="page-content" id="profile-scroll-box">
      <div class="profile" id="profile-reference">
        <div class="profile-top">
          
          <div class="header">
            <h1>@{{ profile.nickname }}</h1>
            <div class="header-buttons">
              <div class="item" >
                <icon icon="popup" size="small"/>
              </div>
            </div>
          </div>

          <profile_main_info :user="profile"/>

          <div class="action-buttons">

            <button class="action" v-if="!subscribeStatus">
              <icon icon="plus" size="small"/>
              <span>Подписаться</span>
            </button>

            <button class="action" v-if="subscribeStatus">
              <span>Вы подписаны</span>
            </button>

            <button class="square"><icon icon="chat"/></button>
          </div>
          
        </div>
        <div class="profile-content">
          <h2>Рецепты</h2>

          <div class="posts recipes">
            <div class="post" v-for="recipe in recipes">
              <img :src="recipe.main_banner_url">
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

</template>
<script>

import profile_main_info from './profile_main_info'

export default {
  props: ['logged', 'user', 'profileID'],
  
  components: {
    profile_main_info
  },

  data() {
    return {
      profile: {},
      recipes: [],
      subscribeStatus: false,
      scrollBox: null
    }
  },
  async mounted() {
    console.log(this.user);
    this.getProfileData();
    this.getUserRecipes();
    this.scrollBox = document.getElementById('profile-scroll-box')
    this.scrollBox.addEventListener("scroll", _.debounce(this.scrollHandler, 200))
  },
  unmounted() {
    this.scrollBox.removeEventListener("scroll", _.debounce(this.scrollHandler, 200))
  },
  methods: {
    getProfileData() {
      axios.post('/get-user-info', {
        id: this.profileID
      }).then((response) => {
        if(response.data[0]) {
          this.profile = response.data[0];
          console.log(this.profile)
        }
      })
    },
    async getUserRecipes(offset = 0) {
      axios.post('/get-user-recipes', {
        offset: offset,
        user_id: this.profileID
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
        this.getUserRecipes(this.recipes.length)
      }
    }
  },
};
</script>
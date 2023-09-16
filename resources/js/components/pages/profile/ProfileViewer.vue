<template>
  <div class="page no-padding" v-if="!isSettingsOpen">

    <div class="page-content" id="profile-scroll-box">
      <div class="profile" id="profile-reference">
        <div class="profile-top">
          
          <div class="header">
            <h1>@{{ user.nickname }}</h1>
            <div class="header-buttons">
              <div class="item" @click="$router.push('/add-recipe')">
                <icon icon="new"/>
              </div>
              <div class="item" >
                <icon icon="notification"/>
              </div>
              <div class="item" @click="isSettingsOpen = true">
                <icon icon="settings"/>
              </div>
            </div>
          </div>

          <div class="main-info">
            <img :src="user.picture">
            <div class="additional-info">
              <div class="item">
                <span>888k</span>
                <p>подписчиков</p>
              </div>
              <div class="item">
                <span>{{ user.recipes_amount }}</span>
                <p>рецептов</p>
              </div>
            </div>
          </div>

          <div class="name">
            <span>{{ user.first_name }} {{ user.last_name }}</span>
            <verified v-if="user.verified"/>
          </div>

          <div class="bio">
            <p>{{ user.bio }}</p>
            <div class="link" v-if="user.site">
              <icon icon="link" size="tiny"/>
              <a :href="user.site" target="_blank">{{ user.site.substring(user.site.indexOf('://') + 3) }}</a>
            </div>
          </div>

          <div class="action-buttons">
            <button class="action" @click="$router.push('/account-editor')"><icon icon="edit" size="small"/><span>Редактировать</span></button>
            <button class="square"><icon icon="chat"/></button>
          </div>
          
        </div>
        <div class="profile-content">
          <h2>Рецепты</h2>
          <!--<profile-folders-slider v-model="selectedTab"/> -->

          <div class="posts recipes" v-if="selectedTab == 0">
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

export default {
  props: ['logged', 'user'],
  
  components: {
    'settings': Settings,
    'profile-folders-slider': profile_folders_slider
  },

  data() {
    return {
      isSettingsOpen: false,
      selectedTab: 0,
      recipes: [],
      articles: [],
      scrollBox: null
    }
  },
  async mounted() {
    console.log(this.user);
    this.getUserRecipes();

    this.scrollBox = document.getElementById('profile-scroll-box')
    this.scrollBox.addEventListener("scroll", _.debounce(this.scrollHandler, 200))
  },
  unmounted() {
    this.scrollBox.removeEventListener("scroll", _.debounce(this.scrollHandler, 200))
  },
  methods: {
    async getUserRecipes(offset = 0) {
      axios.post('/get-user-recipes', {
        offset: offset,
        user_id: this.user.id
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
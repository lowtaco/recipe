<template>
  <div class="profile_main_info">
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
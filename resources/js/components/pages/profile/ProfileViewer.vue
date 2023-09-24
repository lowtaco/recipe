<template>
  <div class="page no-padding">
    <loader v-if="loading"/>

    <div class="page-content" id="profile-scroll-box">
      <div class="profile" id="profile-reference">
        <div class="profile-top">
          
          <div class="header">
            <div class="profile-nickname">
              <div class="back" @click="$router.back()">
                <icon icon="back"/>
              </div>
              <h1>@{{ profile.nickname }}</h1>
            </div>
            
            <div class="header-buttons">
              <div class="item" >
                <icon icon="popup" size="small"/>
              </div>
            </div>
          </div>

          <profile_main_info :user="profile"/>

          <div class="action-buttons">
            <button class="action" v-if="!subscribeStatus" @click="subscribeToUser">
              <loader v-if="subscribeStatusLoading"/>
              <icon icon="plus" size="small"/>
              <span>Подписаться</span>
            </button>

            <button class="action" v-if="subscribeStatus" @click="unsubscribeToUser">
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
      loading: true,
      profile: {},
      recipes: [],
      subscribeStatus: false,
      subscribeStatusLoading: false,
      scrollBox: null
    }
  },
  async mounted() {
    console.log(this.user);
    await this.getProfileData();
    await this.getUserRecipes();
    await this.checkSubscription();
    this.loading = false;
    this.scrollBox = document.getElementById('profile-scroll-box');
    this.scrollBox.addEventListener("scroll", _.debounce(this.scrollHandler, 200));
  },
  unmounted() {
    this.scrollBox.removeEventListener("scroll", _.debounce(this.scrollHandler, 200));
  },
  methods: {
    async getProfileData() {
      try {
        const response = await axios.post('/get-user-info', {id: this.profileID});
        this.profile = response.data[0];
        console.log(this.profile);
      } catch (e) {
        console.log(e);
      }
    },

    async getUserRecipes(offset = 0) {
      try {
        const response = await axios.post('/get-user-recipes', {
          offset: offset,
          user_id: this.profileID
        })
        this.recipes = this.recipes.concat(response.data) ;
      } catch (e) {
        console.log(e);
      }
    },

    async checkSubscription() {
      try {
        const response = await axios.post('/check-subscription', {
          profile_id: this.profileID,
          subscriber_id: this.user.id
        })
        if (response.data) {
          this.subscribeStatus = true;
        } else {
          this.subscribeStatus = false;
        }
      } catch (e) {
        console.log(e);
      } finally {
        this.subscribeStatusLoading = false;
      }
    },

    async subscribeToUser() {
      try {
        this.subscribeStatusLoading = true;
        const response = await axios.post('/subscribe-to-user', {
          profile_id: this.profileID,
          subscriber_id: this.user.id
        })
        await this.checkSubscription();
        this.profile.subscribers_amount = response.data;
      } catch (e) {
        console.log(e);
      }
    },

    async unsubscribeToUser() {
      try {
        this.subscribeStatusLoading = true;
        const response = await axios.post('/unsubscribe-to-user', {
          profile_id: this.profileID,
          subscriber_id: this.user.id
        })
        await this.checkSubscription();
        this.profile.subscribers_amount = response.data;
      } catch (e) {
        console.log(e);
      }
    },

    scrollHandler() {
      let reference = document.getElementById('profile-reference');
      let scrollTop = Math.round(this.scrollBox.scrollTop);
      let rect = this.scrollBox.getBoundingClientRect();
      let viewportHeight = Math.round(rect.height);
      let totalHeight = reference.offsetHeight;
      let currentHeight = scrollTop + viewportHeight;
      if(currentHeight >= (totalHeight * 0.75)) {
        this.getUserRecipes(this.recipes.length);
      }
    }
  },
};
</script>
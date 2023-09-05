<template>
  <div class="page no-padding" v-if="!isSettingsOpen">

    <div class="page-content">
      <div class="profile">
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
            <div class="post">
              1
            </div>
            <div class="post">
              2
            </div>
            <div class="post">
              3
            </div>
            <div class="post">
              4
            </div>
            <div class="post">
              5
            </div>
            <div class="post">
              6
            </div>
            <div class="post">
              2
            </div>
            <div class="post">
              3
            </div>
            <div class="post">
              4
            </div>
            <div class="post">
              5
            </div>
            <div class="post">
              6
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
    }
  },
  mounted() {
    console.log(this.user)
  },
  methods: {
    
  },
};
</script>
<template>
  <div class="page no-padding" v-if="!isSettingsOpen">
    
    <div class="page-header no-border absolute transparent">
      <h1>Аккаунт</h1>
      <div class="header-buttons">
        <div class="item">
          <icon icon="edit"/>
        </div>
        <div class="item" @click="isSettingsOpen = true">
          <icon icon="settings"/>
        </div>
      </div>
    </div>

    <div class="page-content">
      <div class="profile">
        <div class="profile-top">

          <div class="main-info">
            <img src="https://sm.ign.com/ign_nordic/cover/a/avatar-gen/avatar-generations_prsz.jpg">
            <div class="name">
              <h1>Yarik Kudryavtsev</h1>
              <h4>@paintedfriend</h4>
              <span>ontimeyarik@gmail.com</span>
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
            <div class="item">
              <button>Подписаться</button>
            </div>
          </div>

        </div>
        <div class="profile-content">

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

export default {
  props: ['logged', 'user'],
  
  components: {
    'settings': Settings
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
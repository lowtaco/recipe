<template>
  <div class="page profile no-padding" v-if="logged && !isSettingsOpen">
    
    <div class="page-header">
      <h1>Аккаунт</h1>
      <div class="header-buttons">
        <button @click="$emit('debug')">Debug</button>
        <div class="item">
          <icon icon="edit"/>
        </div>
        <div class="item" @click="isSettingsOpen = true">
          <icon icon="settings"/>
        </div>
      </div>
    </div>

    <div class="page-content" v-if="logged">
      <div class="account-details">
        <div class="profile-header">
          <div class="ph-avatar">
            <img :src="user.picture">
          </div>
          <div class="ph-info">
            <span>{{ user.name }}</span>
            <a>{{ user.email }}</a>
          </div>
        </div>
       
      </div>
    </div>

  </div>

  <div class="page auth-account" v-if="!logged">
    <component is="Auth"></component>
  </div>

  <div class="page p-settings" v-if="logged && isSettingsOpen">
    <settings @goBack="isSettingsOpen = false"/>
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
  },
  methods: {
    
  },
};
</script>
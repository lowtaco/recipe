<template>
  <div class="page settings no-padding">
    
    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$emit('goBack')"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <h1>Настройки</h1>
      </div>
    </div>

    <div class="page-content">
      <div class="page-wrapper no-gap no-padding">
        <div class="divider"><span>Личное</span></div>
        <button class="line">Понравившееся рецепты</button>
        <button class="line">Мои рецепты</button>
        <div class="divider"><span>Меню</span></div>
        <div class="switchbox" @click="settings.mobile_menu.labels = !settings.mobile_menu.labels">
          <span>Отображать названия пунктов меню</span>
          <input @click="settings.mobile_menu.labels = !settings.mobile_menu.labels" id="switchcheckbox" type="checkbox" :checked="settings.mobile_menu.labels"/><label for="switchcheckbox" id="switch"></label>
        </div>
        <div class="divider"><span>Информация</span></div>
        <button class="line">Политика конфиденциальности</button>
        <button class="line">Написать в поддержку</button>
        <button class="line" @click="$emit('debug')">Debug</button>
        <button class="line logout" @click="logout">Выйти</button>
      </div>
    </div>

  </div>
</template>
<script>
import { onSignout } from 'vue-google-identity';

export default {
  data() {
    return {
      settings: {
        mobile_menu: {
          labels: false
        }
      }
    }
  },
  watch: {
  },
  methods: {
    logout() {
      if(confirm(this.$strings.pages.account.logout)) {
        // Remove data from localStorage
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        // Google Auth dismiss AutoLogin
        onSignout();
        //Reload Page
        location.reload();
      }
    }
  },
};
</script>
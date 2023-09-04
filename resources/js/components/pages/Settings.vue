<template>
  <div class="page settings no-padding">
    
    <div class="page-header">
      <div class="header-w-button">
        <button @click="$emit('goBack')">N</button>
        <h1>Настройки</h1>
      </div>
    </div>

    <div class="page-content">
      <div class="settings-menu">
        <div class="divider"><span>Личное</span></div>
        <div class="button line">Понравившееся рецепты</div>
        <div class="button line">Мои рецепты</div>
        <div class="divider"><span>Меню</span></div>
        <div class="switchbox" @click="settings.mobile_menu.labels = !settings.mobile_menu.labels">
          <span>Отображать названия пунктов меню</span>
          <input @click="settings.mobile_menu.labels = !settings.mobile_menu.labels" id="switchcheckbox" type="checkbox" :checked="settings.mobile_menu.labels"/><label for="switchcheckbox" id="switch"></label>
        </div>
        <div class="divider"><span>Информация</span></div>
        <div class="button line">Политика конфиденциальности</div>
        <div class="button line">Написать в поддержку</div>
        <div class="button line logout" @click="logout">Выйти</div>
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
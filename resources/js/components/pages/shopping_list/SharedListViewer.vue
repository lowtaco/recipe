<template>
  <div class="popup-menu-wrapper">
    <div class="popup-menu padding">
      <switch-input placeholder="Включить общий доступ"/>

      <div class="divider line"/>

      <div class="shared-list-users">
        <div class="user">
          <div class="info">
            <div class="picture">

            </div>
            <div class="name">
              <span>paintedfriend</span>
            </div>
          </div>
          <div class="remove-user">
            <icon icon="close" size="small"/>
          </div>
        </div>
        <div class="user">
          <div class="info">
            <div class="picture">

            </div>
            <div class="name">
              <span>paintedfriend</span>
            </div>
          </div>
          <div class="remove-user">
            <icon icon="close" size="small"/>
          </div>
        </div>
      </div>

      <div class="add-new-shared-list-user">
        <div class="divider simple"><span>Добавить пользователя</span></div>
        <input type="text" placeholder="E-mail">
        <button class="big">Отправить приглашение</button>
      </div>

    </div>
    <div class="popup-menu-fake-bg" @click="$emit('goBack')"></div>
  </div>
</template>
<script>

export default {
  props: ['token'],
  data() {
    return {

    }
  },
  mounted() {
    
  }
};
</script>
<template>
  <div class="profile-main-info" v-if="user">
    <div class="main-info">
      <img :src="user.picture">
      <div class="additional-info">
        <div class="item">
          <span>888k</span>
          <p>подписчиков</p>
        </div>
        <div class="item">
          <span>{{ user.recipes_amount }}</span>
          <p>{{ makeRecipesEnd }}</p>
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
  props: ['user'],
  computed: {
    makeRecipesEnd() {
      return утилиты.makeStringEnding(this.user.recipes_amount, ["рецепт", "рецепта", "рецептов"]);
    }
  }
};
</script>
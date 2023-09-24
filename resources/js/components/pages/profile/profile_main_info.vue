<template>
  <div class="profile-main-info" v-if="user">
    <div class="main-info">
      <img :src="user.picture">
      <div class="additional-info">
        <div class="item">
          <span v-if="user.subscribers_amount">{{ user.subscribers_amount }}</span>
          <span v-if="!user.subscribers_amount">0</span>
          <p>{{ makeSubscribersEnd }}</p>
        </div>

        <div class="item" v-if="subsriptionsShow">
          <span v-if="user.subscriptions_amount">{{ user.subscriptions_amount }}</span>
          <span v-if="!user.subscriptions_amount">0</span>
          <p>{{ makeSubscriptionsEnd }}</p>
        </div>

        <div class="item">
          <span v-if="user.recipes_amount">{{ user.recipes_amount }}</span>
          <span v-if="!user.recipes_amount">0</span>
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
  props: ['user', 'subsriptionsShow'],
  computed: {
    makeRecipesEnd() {
      return утилиты.makeStringEnding(this.user.recipes_amount, ["рецепт", "рецепта", "рецептов"]);
    },
    makeSubscribersEnd() {
      return утилиты.makeStringEnding(this.user.subscribers_amount, ["подписчик", "подписчика", "подписчиков"]);
    },
    makeSubscriptionsEnd() {
      return утилиты.makeStringEnding(this.user.subscriptions_amount, ["подписка", "подписки", "подписок"]);
    }
  }
};
</script>
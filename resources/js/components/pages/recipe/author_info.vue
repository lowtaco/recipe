<template>
  <div class="author">
    <div class="info">
      <div class="picture" @click="openProfile">
        <img :src="author.picture" >
      </div>
      <div class="name" @click="openProfile">
        <h4>{{ author.first_name }} {{ author.last_name }}</h4>
        <span>@{{ author.nickname }}</span>
      </div>
    </div>

    <button class="small plane" @click="$emit('subscribe')" v-if="!subscribeStatus">
      Подписаться
    </button>

    <button class="small plane gray" @click="$emit('unsubscribe')" v-if="subscribeStatus">
      Вы подписаны
    </button>

  </div>
</template>
<script>

export default {
  props: ['author', 'subscribeStatus'],
  methods: {
    openProfile() {
      this.$router.push('/profile/' + this.author.id)
    }
  }
};
</script>
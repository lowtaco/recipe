<template>
  <div class="author">
    <div class="info">
      <div class="picture" @click="">
        <img :src="picture" >
      </div>
      <div class="name">
        <h4>{{ first_name }} {{ last_name }}</h4>
        <span>@{{ nickname }}</span>
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
  props: ['picture', 'nickname', 'first_name', 'last_name', 'subscribeStatus'],
};
</script>
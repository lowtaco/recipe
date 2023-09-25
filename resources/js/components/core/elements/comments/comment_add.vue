<template>
  <div class="comment-add">
    <auto-textarea v-model="comment" placeholder="Ответить"/>
    <div class="send-btn">
      <icon icon="send"/>
    </div>
  </div>
</template>
<script>

export default {
  props: ['user', 'comments'],
  components: {
  },
  data() {
    return {
      comment: ''
    }
  },
  watch: {
   
  },
  mounted() {

  },
};
</script>

<style scoped>
.comment-add {
  display: inline-flex;
  align-items: center;
  width: 100%;
  gap: 8px;
}

</style>
<template>
  <div class="comment-add">
    <auto-textarea v-model="comment" :placeholder="placeholder"/>
    <div class="send-btn" @click="sendComment">
      <icon icon="send"/>
    </div>
  </div>
</template>
<script>

export default {
  props: ['user', 'comments', 'placeholder'],
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
  methods: {
    sendComment() {
      if(this.comment) {
        this.$emit('addComment', this.comment);
      }
    }
  }
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
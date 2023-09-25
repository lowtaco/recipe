<template>
  <h4>Комментарии</h4>
  <comment-add />
  <comments-viewer :comments="comments"/>
</template>
<script>
import axios from 'axios';

export default {
  props: ['user', 'get', 'post', 'postID'],
  data() {
    return {
      comments: []
    }
  },
  async mounted() {
    await this.getComments()
  },
  methods: {
    async getComments() {
      let postID = 68;

      try {
        const response = await axios.post('/get-comments', {
          post_id: postID
        })
        console.log(response)
        this.comments = response.data;

      } catch (e) {
        console.log(e)
      } finally {

      }

    }
  }
};
</script>
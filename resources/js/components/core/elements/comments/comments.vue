<template>
  <h4>Комментарии</h4>
  <comment-add placeholder="Добавить комментарий" @addComment="addComment"/>
  <comments-viewer :comments="comments" :user="user"/>
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
      try {
        const response = await axios.post('/get-comments', {
          post_id: this.postID
        })
        console.log(response)
        this.comments = response.data;

      } catch (e) {
        console.log(e)
      } finally {

      }
    },
    async addComment(body) {
      try {
        await axios.post('/add-comment', {
          is_reply: 0,
          post_id: this.postID,
          author_id: this.user.id,
          body: body,
        })
      this.getComments();
      } catch (e) {
        console.log(e)
      }
    }
  }
};
</script>
<template>
  <h4>Комментарии</h4>
  <comments-viewer :comments="comments"/>
</template>
<script>

export default {
  props: ['user', 'payload'],
  components: {
  },
  data() {
    return {
      comments: [
        {
          author: '@paintedfriend',
          content: 'Все херня я могу лучше получилось не вкусно азазаза',
          likes: 128,
          replies: [
            {
              author: '@paintedfriend',
              content: 'Ты несешь полную чушь, это на самом деле очень вкусно!!!',
              likes: 128,
              replies: [
                {
                  author: '@paintedfriend',
                  content: 'Согласен, брат',
                  likes: 128,
                  replies: [
                    {
                      author: '@paintedfriend',
                      content: 'Я тебе не брат, брат',
                      likes: 128,
                      replies: [
                        {
                          
                        }
                      ] 
                    },
                    {
                      author: '@paintedfriend',
                      content: 'Я тебе не брат, брат',
                      likes: 128,
                      replies: [
                        {
                          
                        }
                      ] 
                    }
                  ] 
                }
              ] 
            }
          ] 
        },
        {
          author: '@paintedfriend',
          content: 'Все херня я могу лучше получилось не вкусно азазаза',
          likes: 128,
          replies: [
            {
              author: '@paintedfriend',
              content: 'Ты несешь полную чушь, это на самом деле очень вкусно!!!',
              likes: 128,
              replies: [
                {
                  author: '@paintedfriend',
                  content: 'Согласен, брат',
                  likes: 128,
                  replies: [
                    {
                      author: '@paintedfriend',
                      content: 'Я тебе не брат, брат',
                      likes: 128,
                      replies: [
                        {
                          
                        }
                      ] 
                    }
                  ] 
                },
                {
                  author: '@paintedfriend',
                  content: 'Согласен, брат',
                  likes: 128,
                  replies: [
                    {
                      author: '@paintedfriend',
                      content: 'Я тебе не брат, брат',
                      likes: 128,
                      replies: [
                        {
                          
                        }
                      ] 
                    }
                  ] 
                }
              ] 
            }
          ] 
        }
      ]
    }
  },
  watch: {
   
  },
  mounted() {

  },
};
</script>
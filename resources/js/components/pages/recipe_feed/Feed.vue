<template>
  <div class="feed">
    <div class="recipe-card" v-for="recipe in recipes">
      <div class="photo">
        <img :src="recipe.main_banner_url">
      </div>
      <div class="title">
        <h4>{{recipe.name}}</h4>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  props: ['checked', 'isText', 'text'],
  data() {
    return {
      recipes: [],
      scrollBox: null
    }
  },
  mounted() {
    this.getRecipes();

    this.scrollBox = document.getElementById('home-scroll-box')
    this.scrollBox.addEventListener("scroll", _.debounce(this.scrollHandler, 200))
  },
  methods: {
    async getRecipes(offset = 0) {
      axios.post('/get-recipes', {
        offset: offset
      }).then((response) => {
        this.recipes = this.recipes.concat(response.data) 
      })
    },

    scrollHandler() {
      let reference = document.getElementById('home-reference')

      let scrollTop = this.scrollBox.scrollTop;
      let viewportHeight = window.innerHeight;
      let totalHeight = reference.offsetHeight + 104 + 57 + 24 + 24;

      const atTheBottom = scrollTop + viewportHeight == totalHeight

      if(atTheBottom) {
        this.getRecipes(this.recipes.length)
      }
    }
  }


};
</script>

<style>
.feed {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-between;
  box-sizing: border-box;
  gap: 16px;

  .recipe-card {
    display: flex;
    flex-direction: column;
    gap: 8px;
    width: 47%;
    box-sizing: border-box;

    .photo {
      aspect-ratio: 4 / 3;
      overflow: hidden;
      border-radius: 20px;

      .test {
        height: 100%;
        width: 100%;
        background-color: antiquewhite;
      }
    }

    .photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .title {
      padding: 0 6px;
    }

    .title h4 {
      font-weight: normal;
      font-size: 16px;
    }
  }
}

</style>
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
      recipes: null
    }
  },
  mounted() {
    this.getRecipes();
  },
  methods: {
    getRecipes() {
      axios.get('/get-recipes').then((response) => {
        console.log(response.data)
        this.recipes = response.data
      })
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
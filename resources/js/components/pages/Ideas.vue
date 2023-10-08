<template>
  <div class="page">
    
    <div class="page-header no-border">
      <h1>Рецепты из моих продуктов</h1>
    </div>

    <div class="page-content">
      <div class="ideas">
        <search-bar :filters="false" @click="fullscreen = !fullscreen"/>
        <select_fullscreen :title="title" request="/get-products" @goBack="fullscreen = false" @selectOption="selectOption" v-if="fullscreen"/>
        <search-tags :tags="ingredients" @delete="deleteIngredient"/>
      </div>
    </div>

    <div class="page-message" v-if="ingredients.length == 0">
      <svg width="128" height="128" viewBox="0 0 163.84 163.84" class="icon" xmlns="http://www.w3.org/2000/svg"><path d="M27.307 68.263a27.307 27.307 0 1 0 54.613 0 27.307 27.307 0 1 0-54.613 0Z" fill="#FFB300"/><path d="M30.72 116.05a27.307 27.307 0 1 0 54.613 0 27.307 27.307 0 1 0-54.613 0Z" fill="#FFB300"/><path d="M129.707 88.31c0-21.05-12.892-16.189-12.892-61.525H84.576c0 45.336-12.896 40.475-12.896 61.525v50.196a4.847 4.847 0 0 0 4.837 4.854h48.357a4.847 4.847 0 0 0 4.833-4.854V88.31z" fill="#90CAF9"/><path d="M119.467 25.603c0 2.826-2.103 5.117-4.693 5.117h-28.16c-2.591 0-4.694-2.29-4.694-5.117V22.19c0-2.826 2.103-5.123 4.693-5.123h28.16c2.591 0 4.693 2.297 4.693 5.123v3.413z" fill="#9C27B0"/><path d="M123.259 132.028a1.614 1.614 0 0 1-1.614 1.621H79.739a1.618 1.618 0 0 1-1.614-1.621V88.31c0-7.004 1.577-10.185 3.963-15.005 2.154-4.342 4.577-9.284 6.366-17.381h24.48c1.785 8.096 4.212 13.036 6.366 17.381 2.383 4.816 3.96 8.001 3.96 15.005v43.718z" fill="#FAFAFA"/><path d="m27.307 88.75 6.826 54.61h95.573l6.827-54.61H27.307zM51.2 133.12h-6.827v-13.653H51.2v13.653zm0-20.48h-6.827V98.987H51.2v13.653zm17.067 20.48H61.44v-13.653h6.827v13.653zm0-20.48H61.44V98.987h6.827v13.653zm17.067 20.48h-6.827v-13.653h6.827v13.653zm0-20.48h-6.827V98.987h6.827v13.653zm17.066 20.48h-6.827v-13.653h6.827v13.653zm0-20.48h-6.827V98.987h6.827v13.653zm17.067 20.48h-6.827v-13.653h6.827v13.653zm0-20.48h-6.827V98.987h6.827v13.653z" fill="#E91E63"/><path d="M141.633 81.92a3.413 3.413 0 0 0-3.413-3.413H25.62a3.413 3.413 0 0 0-3.413 3.413v6.83a3.413 3.413 0 0 0 3.413 3.413h112.599a3.413 3.413 0 0 0 3.413-3.413v-6.83z" fill="#AD1457"/><path d="M54.613 53.009S51.2 30.723 23.893 34.137c6.827 23.893 30.72 18.872 30.72 18.872z" fill="#4CAF50"/></svg>
      <p>Здесь вы можете найти рецепты из продуктов, которые лежат у вас дома. Начните вводить название продукта в поисковое поле и выбирайте нужное. Как только добавите все продукты, нажмите кнопку Найти рецепты</p>
    </div>

    <div class="page-footer">
      <button class="big shadow" @click="$emit('addList')">
        Найти рецепты
      </button>
    </div>

  </div>
</template>
<script>
import select_fullscreen from '../core/elements/select_fullscreen';
export default {
  
  components: {
    select_fullscreen,
  },

  data() {
    return {
      tags: [],
      fullscreen: false,
      ingredients: []
    }
  },
  mounted() {
  },
  methods: {
    selectOption(option) {
      if (option) {
        this.ingredients.push(option);
        this.ingredients = _.uniqWith(this.ingredients, _.isEqual);
      }
    },
    deleteIngredient(id) {
      let filteredIngredients = _.filter(this.ingredients, (item) => {
        return item.id != id;
      });
      this.ingredients = filteredIngredients;
    }
  },
};
</script>
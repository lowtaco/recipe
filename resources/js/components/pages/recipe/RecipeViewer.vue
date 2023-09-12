<template>
  <div class="page no-padding">
    <div class="page-header no-border absolute" style="background-color: transparent;" id="slv-parent">
      <div class="header-w-button between" id="menu">
        <div class="goBackButton" @click="$router.back()"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <div class="popup-menu-button" @click="additionalPopupActive = true" id="slv-popup-btn">•••</div>
      </div>
    </div>

    <div class="page-content" id="scroll-box">
      <loader v-if="loading"/>
      <div class="recipe" >
        <div class="banner">
          <img :src="recipe.main_banner_url" id="scalable" >
          <div class="category" id="category">
            <div class="icon">
              <span>{{ category.icon }}</span>
            </div>
            <span>{{ category.short_name }}</span>
          </div>
        </div>

        <div class="content" id="ref-box">
          <div class="swipe-trigger"></div>
          <div class="recipe-info">
            <info_header :name="recipe.name" :kitchen="kitchen" @like="" @save=""/>
            <author_info :picture="author.picture" :nickname="author.nickname" :first_name="author.first_name" :last_name="author.last_name"/>
            <difficulty_spiciness />
            <additional_info :description="recipe.description"/>
            <cpaf protein='34' fat='28' carbs='16' :startDelay="loading"/>
            <ingredients_viewer :ingredients="ingredients" :servings="servings"/>
            <recipe_steps :steps="recipe.recipe_steps" :serving="recipe.serving"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import info_header from './info_header';
import author_info from './author_info';
import difficulty_spiciness from './difficulty_spiciness'
import additional_info from './additional_info'
import cpaf from './cpaf';
import ingredients_viewer from './ingredients_viewer'
import recipe_steps from './recipe_steps'

export default {
  props: {
    id: {
      type: String,
      default: '46'
    }
  },
  components: {
    info_header,
    author_info,
    difficulty_spiciness,
    additional_info,
    cpaf,
    ingredients_viewer,
    recipe_steps
  },
  data() {
    return {
      recipe: {},
      author: {},
      kitchen: null,
      category: {},
      scrollBox: null,
      ingredients: [],
      servings: null,
      recipe_id: this.id,
      loading: false
    }
  },
  mounted() {
    console.log(this.id)
    this.scrollBox = document.getElementById('scroll-box')
    this.scrollBox.addEventListener('scroll', this.handleScroll);
    this.getRecipe();
  },
  unmounted() {
    this.scrollBox.removeEventListener("scroll", this.handleScroll);
  },
  computed: {
    
  },
  methods: {
    getRecipe() {
      this.loading = true;
      axios.post('/get-recipe', {
        id: this.recipe_id
      }).then((response) => {
        this.recipe = response.data[0]
        this.recipe.cooking_time = JSON.parse(this.recipe.cooking_time);
        this.recipe.kitchen_time = JSON.parse(this.recipe.kitchen_time);
        this.ingredients = JSON.parse(this.recipe.ingredients);
        this.recipe.cooking_methods = JSON.parse(this.recipe.cooking_methods);
        this.recipe.dishes = JSON.parse(this.recipe.dishes);
        this.servings = this.recipe.servings;
        this.recipe.recipe_steps = JSON.parse(this.recipe.recipe_steps);
        this.recipe.serving = JSON.parse(this.recipe.serving);
        this.recipe.meal = JSON.parse(this.recipe.meal)
        console.log(this.recipe)
        this.loading = false;
        this.getUserInfo();
        this.getKitchen();
        this.getCategory();
      })
    },
    getUserInfo() {
      this.loading = true;
      axios.post('/get-user-info', {
        id: this.recipe.author
      }).then((response) => {
        this.author = response.data[0];
        this.loading = false;
      })
    },
    getKitchen() {
      this.loading = true;
      axios.post('/get-recipe-kitchen', {
        id: this.recipe.kitchen
      }).then((response) => {
        this.kitchen = response.data[0].name
        this.loading = false;
      })
    },
    getCategory() {
      this.loading = true;
      axios.post('/get-recipe-category', {
        id: this.recipe.category
      }).then((response) => {
        this.category = response.data[0]
        this.loading = false;
      })
    },
    handleScroll () {
      let reference = document.getElementById('ref-box')
      let rect = reference.getBoundingClientRect()
      let y = rect.y
      let scalable = document.getElementById('scalable');

      let menu = document.getElementById('menu');
      let category = document.getElementById('category');

      if (y < 200) {
        scalable.style.transform = `scale(${1.5})`;
        scalable.style.opacity = 0.5;
        menu.style.opacity = 0;
        category.style.opacity = 0;
        reference.style.borderRadius = '0 0 0 0'
      } else {
        scalable.style.transform = `scale(${1})`;
        scalable.style.opacity = 1;
        menu.style.opacity = 1;
        category.style.opacity = 1;
        reference.style.borderRadius = '30px 30px 0 0'
      }
    }
  }


};
</script>

<style>

</style>
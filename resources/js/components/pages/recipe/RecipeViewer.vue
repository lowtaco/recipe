<template>
  <div class="page no-padding">
    <div class="page-header no-border absolute" style="background-color: transparent;" id="slv-parent">
      <div class="header-w-button between recipe" id="menu">
        <div class="goBackButton" @click="$router.back()"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <div class="popup-menu-button" @click="additionalPopupActive = true" id="slv-popup-btn">•••</div>
      </div>
    </div>

    <div class="page-content" id="scroll-box">
      <loader v-if="loading"/>
      <div class="recipe" >
        <div class="banner">
          <img :src="recipe.main_banner_url" id="scalable" >
          <div class="category" id="category" v-if="recipe.category">
            <div class="icon">
              <span>{{ recipe.category.icon }}</span>
            </div>
            <span>{{ recipe.category.short_name }}</span>
          </div>
        </div>

        <div class="content" id="ref-box">
          <div class="swipe-trigger"></div>
          <div class="recipe-info">
            <info_header :name="recipe.name" :kitchen="recipe.kitchen" @like="" @save=""/>
            <author_info v-if="recipe.author" @subscribe="subscribe" @unsubscribe="unsubscribe" :subscribeStatus="subscribeStatus" :picture="recipe.author.picture" :nickname="recipe.author.nickname" :first_name="recipe.author.first_name" :last_name="recipe.author.last_name"/>
            <difficulty-spiciness-viewer :total="5" :spiciness="recipe.spiciness" :difficulty="recipe.difficulty"/>
            <additional_info :description="recipe.description" :cooking_time="recipe.cooking_time" :kitchen_time="recipe.kitchen_time" :meal="meal_string" :cooking_methods='cooking_methods_string' :dishes="dishes_string"/>
            <cpaf :kcal="recipe.kcal" :protein="recipe.protein" :fat="recipe.fat" :carbs="recipe.carbs" :startDelay="loading"/>
            <ingredients_viewer :ingredients="ingredients" :servings="recipe.servings" :recipeId="recipe.id" :recipeName="recipe.name" :recipeAuthor="recipe.author" :picture="recipe.main_banner_url"/>
            <recipe_steps :steps="recipe.recipe_steps" :serving="recipe.serving"/>
            <comments :user="user" :postID="id"/>
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
    },
    user: {
      type: Array
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
      scrollBox: null,
      ingredients: [],
      recipe_id: this.id,
      meal_string: '',
      cooking_methods_string: '',
      subscribeStatus: null,
      dishes_string: '',
      loading: false
    }
  },
  mounted() {
    this.scrollBox = document.getElementById('scroll-box')
    this.scrollBox.addEventListener('scroll', this.handleScroll);
    this.getRecipe();
    this.$emit("hideMenu", true);
  },
  unmounted() {
    this.scrollBox.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    async getRecipe() {
      this.loading = true;
      try {
        const response = await axios.post('/get-recipe', {id: this.recipe_id});
        this.recipe = response.data[0];
        this.recipe.cooking_time = JSON.parse(this.recipe.cooking_time);
        this.recipe.kitchen_time = JSON.parse(this.recipe.kitchen_time);
        this.ingredients = JSON.parse(this.recipe.ingredients);
        this.recipe.cooking_methods = JSON.parse(this.recipe.cooking_methods);
        this.recipe.dishes = JSON.parse(this.recipe.dishes);
        this.recipe.recipe_steps = JSON.parse(this.recipe.recipe_steps);
        this.recipe.serving = JSON.parse(this.recipe.serving);
        this.recipe.meal = JSON.parse(this.recipe.meal);
        this.recipe.cooking_time = утилиты.convertTime(this.recipe.cooking_time);
        this.recipe.kitchen_time = утилиты.convertTime(this.recipe.kitchen_time);
        console.log(this.recipe);

        const user = await axios.post('/get-user-info', {id: this.recipe.author});
        this.recipe.author = user.data[0];

        const kitchen = await axios.post('/get-user-info', {id: this.recipe.author});
        this.recipe.kitchen = kitchen.data[0].name;

        const category = await axios.post('/get-recipe-category', {id: this.recipe.category});
        this.recipe.category = category.data[0];

        _.forEach(this.recipe.meal, async (mealId) => {
          const meal = await axios.post('/get-recipe-meal', {
            id: mealId
          })
          this.meal_string += meal.data[0].name.toLowerCase() + ', ';
        })

        _.forEach(this.recipe.dishes, async (dishesId) => {
          const dishes = await axios.post('/get-recipe-dishes', {id: dishesId});
          this.dishes_string += dishes.data[0].name.toLowerCase() + ', ';
        })

        _.forEach(this.recipe.cooking_methods, async (methodId) => {
          const cooking_methods = await axios.post('/get-recipe-cooking-methods', {id: methodId});
          this.cooking_methods_string += cooking_methods.data[0].name.toLowerCase() + ', ';
        })

        await this.checkSubscription();
      } catch (e) {
        console.log(e);
      } finally {
        this.loading = false;
      }
    },
    async checkSubscription() {
      try {
        const response = await axios.post('/check-subscription', {
          profile_id: this.recipe.author.id,
          subscriber_id: this.user.id
        })
        if (response.data) {
          this.subscribeStatus = true;
        } else {
          this.subscribeStatus = false;
        }
      } catch (e) {
        console.log(e);
      }
    },
    async subscribe() {
      try {
        this.subscribeStatusLoading = true;
        await axios.post('/subscribe-to-user', {
          profile_id: this.recipe.author.id,
          subscriber_id: this.user.id
        })
        await this.checkSubscription();
      } catch (e) {
        console.log(e);
      }
    },
    async unsubscribe() {
      try {
        this.subscribeStatusLoading = true;
        await axios.post('/unsubscribe-to-user', {
          profile_id: this.recipe.author.id,
          subscriber_id: this.user.id
        })
        await this.checkSubscription();
      } catch (e) {
        console.log(e);
      }
    },
    handleScroll () {
      let reference = document.getElementById('ref-box');
      let rect = reference.getBoundingClientRect();
      let y = rect.y;
      let scalable = document.getElementById('scalable');

      let menu = document.getElementById('menu');
      let category = document.getElementById('category');

      if (y < 200) {
        scalable.style.transform = `scale(${1.5})`;
        scalable.style.opacity = 0.5;
        menu.style.opacity = 0;
        category.style.opacity = 0;
        reference.style.borderRadius = '0 0 0 0';
      } else {
        scalable.style.transform = `scale(${1})`;
        scalable.style.opacity = 1;
        menu.style.opacity = 1;
        category.style.opacity = 1;
        reference.style.borderRadius = '30px 30px 0 0';
      }
    }
  }
};
</script>
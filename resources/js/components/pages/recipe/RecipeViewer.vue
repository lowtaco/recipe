<template>
  <div class="page no-padding">
    
    <div class="page-header no-border absolute" style="background-color: transparent;" id="slv-parent">
      <div class="header-w-button between">
        <div class="goBackButton" @click="$emit('goBack')"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <div class="list-viewer-shared"></div>
        <div class="popup-menu-button" @click="additionalPopupActive = true" id="slv-popup-btn">•••</div>
      </div>
    </div>

    
    <div class="page-content" id="scroll-box">
      <loader v-if="loading"/>

      <div class="recipe" >
        <div class="banner">
          <img src="https://w.forfun.com/fetch/00/00c3d0bc0617f22de4af13e6322b6e58.jpeg" id="scalable" >
          <div class="category">
            <div class="icon">
              <span>{{ category.icon }}</span>
            </div>
            <span>{{ category.short_name }}</span>
          </div>
        </div>

        <div class="content" id="ref-box">
          <div class="swipe-trigger"></div>

          <div class="recipe-info">
            <div class="info-header">
              <div class="title">
                <h1>{{ recipe.name }}</h1>
                <span>{{ kitchen }} кухня</span>
              </div>
              <div class="like-buttons">
                <div class="item">
                  <icon icon="like"/>
                </div>
                <div class="item">
                  <icon icon="favorite"/>
                </div>
              </div>
            </div>

            <div class="description">
              <p>{{ recipe.description }}</p>
            </div>

            <div class="author">
              <div class="picture">
                <img :src="author.picture">
              </div>
              <div class="name">
                <h4>{{ this.author.first_name }} {{ this.author.last_name }}</h4>
                <span>@{{ this.author.nickname }}</span>
              </div>
            </div>

            <div class="difficulty-spiciness">
              <div class="card">
                <div class="icon-row">
                  <span>🌶️</span>
                  <span>🌶️</span>
                  <span>🌶️</span>
                  <span>🌶️</span>
                  <span>🌶️</span>
                </div>
                <span>Острота</span>
              </div>
              <div class="card">
                <div class="icon-row">
                  <span>👨🏻‍🍳</span>
                  <span>👨🏻‍🍳</span>
                  <span>👨🏻‍🍳</span>
                  <span>👨🏻‍🍳</span>
                  <span>👨🏻‍🍳</span>
                </div>
                <span>Сложность</span>
              </div>
            </div>

            <div class="additional-info">
              <div class="timings">
                <div class="card">
                  <span>1 час</span>
                  <p>Время приготовления</p>
                </div>
                <div class="card">
                  <span>25 минут</span>
                  <p>Время на кухне</p>
                </div>
              </div>

              <span>Подойдет на:</span>
              <div class="inline-row-text">
                <span v-for="meal in this.recipe.meal">{{ meal.name }}</span>
              </div>

              <span>Способы приготовления:</span>
              <div class="inline-row-text">
                <span v-for="item in cooking_methods">{{ item.name }}</span>
              </div>
              
              <span>Посуда:</span>
              <div class="inline-row-text">
                <span v-for="item in dishes">{{ item.name }}</span>
              </div>
            </div>
            
            <div class="recipe-ingredients-viewer">
              <h4>Ингредиенты</h4>
              <div class="servings-editor">
                <span>Порции</span>
                <num-editor v-model="servings" @changed="servingsEditor"/>
              </div>

              <div class="ingredients">

                <div class="ingredient" v-for="ingredient in ingredients">
                  <span>{{ ingredient.name }}</span>
                  <span>{{ ingredient.amount }} {{ ingredient.unit.name }}</span>
                </div>

              </div>
              <button class="big">Добавить в список покупок</button>
            </div>

            <h4>Пошаговый рецепт</h4>
            <div class="recipe-steps">
              <div class="recipe-step" v-for="(step, index) in recipe.recipe_steps">
                <span>Шаг {{ index + 1 }}</span>
                <p>{{ step.desc }}</p>
                <div class="picture">
                  <img src="https://w.forfun.com/fetch/00/00c3d0bc0617f22de4af13e6322b6e58.jpeg">
                </div>
              </div>

              <div class="recipe-step" v-if="recipe.serving">
                <span>Подача</span>
                <p>{{ recipe.serving.desc }}</p>
                <div class="picture">
                  <img src="https://w.forfun.com/fetch/00/00c3d0bc0617f22de4af13e6322b6e58.jpeg">
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    
    </div>


  </div>
</template>
<script>
import axios from 'axios';


export default {
  props: ['checked', 'isText', 'text'],
  data() {
    return {
      recipe: {},
      author: {},
      kitchen: null,
      category: {},
      scrollBox: null,
      ingredients: [],
      ingredients_reference: [],
      cooking_methods: [],
      dishes: [],
      servings: null,
      recipe_id: 44,
      loading: false
    }
  },
  mounted() {
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
        this.ingredients = JSON.parse(this.recipe.ingredients);
        this.ingredients_reference = JSON.parse(this.recipe.ingredients);
        this.cooking_methods = JSON.parse(this.recipe.cooking_methods);
        this.dishes = JSON.parse(this.recipe.dishes);
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
    servingsEditor() {
      // Записываем изначальное количество порций
      const servings_reference = this.recipe.servings;

      // Цикл по изначальному списку ингредиентов
      _.forEach(this.ingredients_reference, (ingredient, index) => {
        // Считаем количество ингредиента на одну порцию
        let amount_one = ingredient.amount / servings_reference;
        // Вычисляем количество ингрдиента на нужное количество порций
        let new_amount = amount_one * this.servings;

        new_amount = Math.round(new_amount * 100) / 100
        // Записываем данные в локальный массив ингредиентов
        this.ingredients[index].amount = new_amount;
      })
    },
    handleScroll () {
      let reference = document.getElementById('ref-box')
      let rect = reference.getBoundingClientRect()
      let y = rect.y
      let scalable = document.getElementById('scalable')

      if (y < 200) {
        scalable.style.transform = `scale(${1.5})`;
        scalable.style.opacity = 0.5;
        reference.style.borderRadius = '0 0 0 0'
      } else {
        scalable.style.transform = `scale(${1})`;
        scalable.style.opacity = 1;
        reference.style.borderRadius = '30px 30px 0 0'
      }
    }
  }


};
</script>

<style>

</style>
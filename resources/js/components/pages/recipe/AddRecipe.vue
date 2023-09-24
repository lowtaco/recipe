<template>
  <div class="page">
    <loader v-if="loading" :status="loading_status"/>
    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$router.back()"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <h1>Новый рецепт</h1>
      </div>
    </div>

    <div class="page-content">
      
      <div class="page-wrapper">
        <form-title title="Фотография готового блюда"/>
        <photo-uploader v-model="main_banner" type="single"/>

        <form-title title="Основная информация"/>
        <input v-model="name" type="text" placeholder="Название рецепта">
        <auto-textarea v-model="description" placeholder="Описание рецепта"/>
        <r-select v-model="kitchen" request="/get-recipes-kitchens" placeholder="Национальная кухня"/>
        <r-select v-model="category" request="/get-recipes-categories" placeholder="Категория"/>
        <input v-model="servings" type="number" placeholder="Порции">

        <difficulty-spiciness-editor @spiciness="spicinessCallback" @difficulty="difficultyCallback"/>

        <form-title title="Прием пищи"/>
        <div class="checkbox-box">
          <div class="checkbox-item" v-for="item in meal" @click="item.checked = !item.checked">
            <checkbox :checked="item.checked" isText="true" :text="item.name" />
          </div>
        </div>

        <form-title title="Время приготовления"/>
        <time-input v-model="cooking_time"/>

        <form-title title="Время на кухне"/>
        <time-input v-model="kitchen_time" />

        <form-title title="Средства приготовления"/>
        <draggable-list v-model="cooking_methods" request="/get-cooking-methods" title="Способ приготовления" type="list" placeholder="Добавить позицию"/>

        <form-title title="Посуда"/>
        <draggable-list v-model="dishes" request="/get-cooking-dishes" title="Посуда" type="list" placeholder="Добавить посуду"/>

        <form-title title="Ингредиенты"/>
        <draggable-list v-model="ingredients" type="ingredient" placeholder="Добавить ингредиент"/>

        <form-title title="Пошаговый Рецепт"/>

        <recipe-fileds v-model="steps" placeholder="Описание шага" />

        <form-title title="Подача блюда"/>
        <auto-textarea v-model="serving.desc" placeholder="Описание шага"/>
        <photo-uploader v-model="serving.photo" type="single"/>
        
        <button class="big" @click="createRecipe">Создать</button>

      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import recipe_fields from './AddRecipe_recipe_fileds'

export default {
  props: ['lists', 'user'],
  components: {
    'recipe-fileds': recipe_fields
  },
  data() {
    return {
      loading: false,
      loading_status: null,
      main_banner: null,
      name: null,
      description: null,
      kitchen: null,
      category: null,
      servings: null,
      cooking_time: null,
      kitchen_time: null,
      spiciness: null,
      difficulty: null,
      meal: [],
      cooking_methods: null,
      dishes: null,
      ingredients: null,
      steps: [],
      kcal: null,
      bgu: {},
      serving: {
        desc: null,
        photo: null
      },
    }
  },
  mounted() {
    this.$emit("hideMenu", true);
    this.getMeals();
  },
  unmounted() {
    this.$emit("hideMenu", false);
  },
  methods: {
    spicinessCallback(value) {
      this.spiciness = value;
    },
    difficultyCallback(value) {
      this.difficulty = value;
    },
    getMeals() {
      axios.get('/get-meals').then((response) => {
        this.meal = response.data;
        _.forEach(this.meal, (meal) => {
          meal.checked = false;
        })
      })
    },
    objValuesToArray(array, key) {
      let arr = [];
      _.forEach(array, (element) => {
        if (element && key && element[key]) {
          arr.push(element[key]);
        }
      })
      return arr;
    },

    getCalories(ingredients) {
      let kcal_total = null;
      let bgu_total = {
        protein: 0,
        fat: 0,
        carbs: 0
      }
      let weight_total = 0;
      let kcal_100 = 0;
      let bgu_100 = {
        protein: 0,
        fat: 0,
        carbs: 0
      }

      _.forEach(ingredients, (ingredient) => {
        let bgu_product = утилиты.getBGU(ingredient.bgu)
        
        let g = 1;
        if (ingredient.unit.id == 6) {
          g = 1;
        } else if (ingredient.unit.id == 10) {
          g = 1000;
        }
        // Считаем общий вес блюда
        weight_total += (ingredient.amount * g);
        
        // Считаем общее КБЖУ блюда на весь вес
        kcal_total += (ingredient.kcal / 100) * (ingredient.amount * g);
        bgu_total.protein += (bgu_product.protein / 100) * (ingredient.amount * g);
        bgu_total.fat += (bgu_product.fat / 100) * (ingredient.amount * g);
        bgu_total.carbs += (bgu_product.carbs / 100) * (ingredient.amount * g);
      })
      // Считаем КБЖУ блюда на 100 гр
      kcal_100 = (kcal_total / weight_total) * 100
      bgu_100.protein = (bgu_total.protein / weight_total) * 100
      bgu_100.fat = (bgu_total.fat / weight_total) * 100
      bgu_100.carbs = (bgu_total.carbs / weight_total) * 100

      // Округляем до 2х знаков после запятой
      kcal_100 = Math.round(kcal_100 * 100) / 100;
      bgu_100.protein = Math.round(bgu_100.protein * 100) / 100;
      bgu_100.fat = Math.round(bgu_100.fat * 100) / 100;
      bgu_100.carbs = Math.round(bgu_100.carbs * 100) / 100;

      this.kcal = kcal_100;
      this.bgu = bgu_100;
    },
    createRecipe() {
      this.loading = true;
      this.loading_status = 'Формируем рецепт';
      let filteredMeals = _.filter(this.meal, (meal) => {
        return meal.checked
      })
      
      this.loading_status = 'Считаем калории';
      this.getCalories(this.ingredients)
      console.log(this.kcal)
      console.log(this.bgu)

      axios.post('/create-recipe', {
        author: this.user.id,
        name: this.name,
        description: this.description,
        main_banner: this.main_banner,
        kitchen: this.kitchen.id,
        category: this.category.id,
        servings: this.servings,
        spiciness: this.spiciness,
        difficulty: this.difficulty,
        cooking_time: JSON.stringify(this.cooking_time),
        kitchen_time: JSON.stringify(this.kitchen_time),
        meal: JSON.stringify(this.objValuesToArray(filteredMeals, 'id')),
        cooking_methods: JSON.stringify(this.objValuesToArray(this.cooking_methods, 'id')),
        dishes: JSON.stringify(this.objValuesToArray(this.dishes, 'id')),
        ingredients: JSON.stringify(this.ingredients),
        serving: JSON.stringify(this.serving),
        kcal: this.kcal,
        protein: this.bgu.protein,
        fat: this.bgu.fat,
        carbs: this.bgu.carbs
      }).then((response) => {
        const id = String(response.data);
        let main_banner_url = null;

        this.loading_status = 'Загружаем фотографии';
        axios.post('/upload-image', {
          image: this.main_banner,
          type: утилиты.decodeImageType(this.main_banner),
          folder: 'recipe',
          name: id
        }).then((main_banner_url_response) => {
          main_banner_url = main_banner_url_response.data;
          axios.post('/upload-image', {
            image: this.serving.photo,
            type: утилиты.decodeImageType(this.serving.photo),
            folder: 'recipe',
            name: id + '_serving'
          }).then((serving_url_response) => {
            this.serving.photo = serving_url_response.data;
            _.forEach(this.steps, (step, index) => {
              axios.post('/upload-image', {
                image: step.photo,
                type: утилиты.decodeImageType(step.photo),
                folder: 'recipe',
                name: id + '_' + index
              }).then((step_photo_url_response) => {
                step.photo = step_photo_url_response.data;
                this.loading_status = 'Ещё немного...';
                axios.post('/updateRecipePhotosUrl', {
                  id: id,
                  main_banner_url: main_banner_url,
                  serving: JSON.stringify(this.serving),
                  recipe_steps: JSON.stringify(this.steps)
                }).then(() => {
                  this.loading = false;
                })
              })
            })
          })
        })
      })
    }
  },
};
</script>
<template>
  <div class="page">
    <loader v-if="loading"/>
    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$emit('goBackHome')"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
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
      main_banner: null,
      name: null,
      description: null,
      kitchen: null,
      category: null,
      servings: null,
      cooking_time: null,
      kitchen_time: null,
      meal: [
        {
          name: 'Завтрак',
          checked: false
        },
        {
          name: 'Обед',
          checked: false
        },
        {
          name: 'Ужин',
          checked: false
        },
        {
          name: 'Перекус',
          checked: false
        }
      ],
      cooking_methods: null,
      dishes: null,
      ingredients: null,
      steps: [],
      serving: {
        desc: null,
        photo: null
      },
    }
  },
  mounted() {
    this.$emit("hideMenu", true);
  },
  methods: {
    createRecipe() {
      this.loading = true;
      let filteredMeals = _.filter(this.meal, (meal) => {
        return meal.checked
      })

      axios.post('/create-recipe', {
        author: this.user.id,
        name: this.name,
        description: this.description,
        main_banner: this.main_banner,
        kitchen: this.kitchen.id,
        category: this.category.id,
        servings: this.servings,
        cooking_time: JSON.stringify(this.cooking_time),
        kitchen_time: JSON.stringify(this.kitchen_time),
        meal: JSON.stringify(filteredMeals),
        cooking_methods: JSON.stringify(this.cooking_methods),
        dishes: JSON.stringify(this.dishes),
        ingredients: JSON.stringify(this.ingredients),
        serving: JSON.stringify(this.serving),
      }).then((response) => {
        const id = String(response.data)

        let main_banner_url = null;
        let serving_url = null;

        axios.post('/upload-image', {
          image: this.main_banner,
          type: утилиты.decodeImageType(this.main_banner),
          name: id
        }).then((main_banner_url_response) => {
          main_banner_url = main_banner_url_response.data;
          axios.post('/upload-image', {
            image: this.serving.photo,
            type: утилиты.decodeImageType(this.serving.photo),
            name: id + '_serving'
          }).then((serving_url_response) => {
            serving_url = serving_url_response.data;
            _.forEach(this.steps, (step, index) => {
              axios.post('/upload-image', {
                image: step.photo,
                type: утилиты.decodeImageType(step.photo),
                name: id + '_' + index
              }).then((step_photo_url_response) => {
                step.photo = step_photo_url_response.data;
                axios.post('/updateRecipePhotosUrl', {
                  id: id,
                  main_banner_url: main_banner_url,
                  serving_photo_url: serving_url,
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
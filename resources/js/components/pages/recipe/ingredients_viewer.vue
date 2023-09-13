<template>
  <div class="recipe-ingredients-viewer">
    <h4>Ингредиенты</h4>
    <div class="servings-editor">
      <span>Порции</span>
      <num-editor v-model="servings_local" @changed="servingsEditor"/>
    </div>

    <div class="ingredients">
      <div class="ingredient" v-for="ingredient in ingredients_local">
        <span>{{ ingredient.name }}</span>
        <span>{{ ingredient.amount }} {{ ingredient.unit.name }}</span>
      </div>
    </div>
    <button @click="addToShoppingList">{{ addToListBtnText }}</button>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  props: ['ingredients', 'servings', 'recipeName', 'recipeAuthor', 'picture'],
  data() {
    return {
      servings_local: this.servings,
      ingredients_local: [],
      addToListBtnText: 'Добавить в список покупок',
      isListExist: false
    }
  },
  watch: {
    servings() {
      this.servings_local = _.cloneDeep(this.servings);
    },
    ingredients() {
      this.ingredients_local = _.cloneDeep(this.ingredients)
    },
    async recipeAuthor() {
      if(this.recipeAuthor) {
        this.findList();
      }
    },
    isListExist() {
      if (this.isListExist) {
        this.addToListBtnText = 'В список покупок';
      } else {
        this.addToListBtnText = 'Добавить в список покупок';
      }
    }
  },
  mounted() {
    
  },
  methods: {
    servingsEditor() {
      // Цикл по изначальному списку ингредиентов
      _.forEach(this.ingredients, (ingredient, index) => {
        // Считаем количество ингредиента на одну порцию
        let amount_one = ingredient.amount / this.servings;
        // Вычисляем количество ингрдиента на нужное количество порций
        let new_amount = amount_one * this.servings_local;

        new_amount = Math.round(new_amount * 100) / 100
        // Записываем данные в локальный массив ингредиентов
        this.ingredients_local[index].amount = new_amount;
      })
    },
    async findList() {
      axios.post('/getShoppingListByName', {
        name: this.recipeName,
        user: this.recipeAuthor.email,
      }).then((response) => {
        if (response.data.length > 0) {
          this.isListExist = true;
        } else {
          this.isListExist = false;
        }
      })
    },
    addToShoppingList() {
      if (!isListExist) {
        _.forEach(this.ingredients_local, (ingredient) => {
          ingredient.checked = false
        })
      
        axios.post('/create-shopping-list', {
            name: this.recipeName,
            user: this.recipeAuthor.email,
            personal: 0,
            picture: this.picture,
            color: '#ccc',
            list: JSON.stringify(this.ingredients_local),
            icon: '🥣'
          }).then((response) => {
            let id = response.data;
            console.log(response)
        })
      }
    }
  }
};
</script>
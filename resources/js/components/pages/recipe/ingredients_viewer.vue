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
    <button>Добавить в список покупок</button>
  </div>
</template>
<script>

export default {
  props: ['ingredients', 'servings'],
  data() {
    return {
      servings_local: this.servings,
      ingredients_local: []
    }
  },
  watch: {
    servings() {
      this.servings_local = _.cloneDeep(this.servings);
    },
    ingredients() {
      this.ingredients_local = _.cloneDeep(this.ingredients)
    }
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
  }
};
</script>
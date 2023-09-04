<template>
  <div class="page fullscreen">

    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$emit('goBack')"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <h1>Добавить ингредиент</h1>
      </div>
    </div>

    <div class="page-content">
      <div class="page-wrapper">
       <input v-model="name" type="text" placeholder="Ингредиент">
        <div class="two-collumns">
          <div class="item">
            <input v-model="amount" type="number" placeholder="Количество">
            
          </div>
          <div class="item">
            <r-select v-model="unit" placeholder="Ед. измерения" request="/get-ingredients-units" title="Единицы измерения"/>
          </div>
        </div>
      </div>
    </div>

    <div class="page-footer">
      <button class="big" @click="addIngredient">Добавить ингредиент</button>
    </div>

  </div>    
</template>
<script>

export default {
  props: ['select'],
  data() {
    return {
      name: null,
      amount: null,
      unit: null
    }
  },
  methods: {
    addIngredient() {
      if(this.name) {
        let ingredient = {
          name: this.name,
          amount: this.amount,
          unit: this.unit
        }
        this.$emit('addIngredient', ingredient);
        this.$emit('goBack');
      }
    }
  }
};
</script>
<template>
  <div class="additional-info">
    
    <div class="card">
      <h4>Описание</h4>
      
      <div class="description"><p>{{ description }}</p></div>
      
      <div class="timings">
        <div class="item">
          <span>1 час</span>
          <p>Время приготовления</p>
        </div>
        <div class="item">
          <span>25 минут</span>
          <p>Время на кухне</p>
        </div>
      </div>

      <div class="list">
        <div class="item">
          <div class="indicator"></div>
          <div class="item-content">
            <span>🌅 Подойдет на:</span>
            <p>Завтрак, обед и ужин</p>
          </div>
        </div>

        <div class="item">
          <div class="indicator"></div>
          <div class="item-content">
            <span>🍳 Способы приготовления:</span>
            <p>Аэрогриль</p>
          </div>
        </div>

        <div class="item">
          <div class="indicator"></div>
          <div class="item-content">
            <span>🍴 Посуда:</span>
            <p>Миксер, соковыжималка</p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</template>
<script>

export default {
  props: ['description', 'fat', 'carbs', 'startDelay'],
  data() {
    return {
      unit: 'гр.',
      delayTime: 1000,
      calories: 0,
      proteinPercents: 0,
      fatPercents: 0,
      carbsPercents: 0
    }
  },
  watch: {
    startDelay() {
      if(this.startDelay == false) {
        this.calculate()
      }
    }
  },
  mounted() {
    //setTimeout(this.calculate, this.delayTime)
  },
  methods: {
    async calculate() {
      let protein = Number(this.protein);
      let fat = Number(this.fat);
      let carbs = Number(this.carbs);

      let total = protein + fat + carbs;

      this.proteinPercents = Math.round(protein / total * 100);
      this.fatPercents = Math.round(fat / total * 100);
      this.carbsPercents = Math.round(carbs / total * 100);

      let kcal_protein = 4;
      let kcal_carbs = 4;
      let kcal_fat = 9;

      this.calories = (this.protein * kcal_protein) + (this.carbs * kcal_carbs) + (this.fat * kcal_fat);
    },
  },
};
</script>
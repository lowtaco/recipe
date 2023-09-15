<template>
  <div class="cpaf">

    <div class="title">
      <h4>Пищевая ценность <span>на 100 гр.</span></h4>
      <div class="calories">
        <icon icon="fire" size="tiny" />
        <span>{{ kcal }} ккал</span>
      </div>
    </div>

    <div class="item protein">
      <div class="iconbox">
        <icon icon="protein" size="big"/>
      </div>
      <div class="info">
        <div class="name">
          <div class="title">
            <span>Белки</span>
            <p>({{ protein }} {{ unit }})</p>
          </div>
          <div class="percents" :style="{'--percent': this.proteinPercents}"></div>
        </div>
        <div class="progress">
          <div class="progress status" :style="{'width': this.proteinPercents + '%'}"></div>
        </div>
      </div>
    </div>

    <div class="item fat">
      <div class="iconbox">
        <icon icon="fat"/>
      </div>
      <div class="info">
        <div class="name">
          <div class="title">
            <span>Жиры</span>
            <p>({{ fat }} {{ unit }})</p>
          </div>
          <div class="percents" :style="{'--percent': this.fatPercents}">
          </div>
        </div>
        <div class="progress" id="fatPercent">
          <div class="progress status" :style="{'width': this.fatPercents + '%'}"></div>
        </div>
      </div>
    </div>

    <div class="item carbs">
      <div class="iconbox">
        <icon icon="carbs" size="big" />
      </div>
      <div class="info">
        <div class="name">
          <div class="title">
            <span>Углеводы</span>
            <p>({{ carbs }} {{ unit }})</p>
          </div>
          <div class="percents" :style="{'--percent': this.carbsPercents}"></div>
        </div>
        <div class="progress">
          <div class="progress status" :style="{'width': this.carbsPercents + '%'}"></div>
        </div>
      </div>
    </div>
    
  </div>
</template>
<script>

export default {
  props: ['kcal', 'protein', 'fat', 'carbs', 'startDelay'],
  data() {
    return {
      unit: 'гр.',
      delayTime: 1000,
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
    },
  },
};
</script>
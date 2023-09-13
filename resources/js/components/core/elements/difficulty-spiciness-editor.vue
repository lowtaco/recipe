<template>
  <div class="difficulty-spiciness-editor">
    <div class="card">
      <div class="edit" @click="spicinessMinus">
        <icon icon="minus"/>
      </div>
      <div class="mid">
        <div class="icon-row spiciness">
          <div class="item" :class="{checked: item <= spiciness}" v-for="item in max">
            <icon icon="spiciness"/>
          </div>
        </div>
        <span>Острота</span>
      </div>
      <div class="edit" @click="spicinessPlus">
        <icon icon="plus"/>
      </div>
    </div>
    <div class="card">
      <div class="edit" @click="difficultyMinus">
        <icon icon="minus"/>
      </div>
      <div class="mid">
        <div class="icon-row difficulty">
          <div class="item" :class="{checked: item <= difficulty}" v-for="item in max">
            <icon icon="difficulty"/>
          </div>
        </div>
        <span>Сложность</span>
      </div>
      <div class="edit" @click="difficultyPlus">
        <icon icon="plus"/>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  data() {
    return {
      max: 5,
      spiciness: 2,
      difficulty: 2
    }
  },
  methods: {
    spicinessMinus() {
      if(this.spiciness > 0) {
        this.spiciness--;
        this.$emit('spiciness', this.spiciness);
      }
    },
    spicinessPlus() {
      if(this.spiciness < this.max) {
        this.spiciness++;
        this.$emit('spiciness', this.spiciness);
      }
    },
    difficultyMinus() {
      if(this.difficulty > 0) {
        this.difficulty--;
        this.$emit('difficulty', this.difficulty);
      }
    },
    difficultyPlus() {
      if(this.difficulty < this.max) {
        this.difficulty++;
        this.$emit('difficulty', this.difficulty);
      }
    } 
  }
};
</script>
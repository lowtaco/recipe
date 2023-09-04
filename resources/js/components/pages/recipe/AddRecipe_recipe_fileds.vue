<template>
  <div class="stepper-recipe">

    <div class="step" v-for="(step, index) in steps">
      <div class="step-header">
        <span>Шаг {{ index + 1 }}</span>
        <div class="header-buttons">
          <!--
            <div class="item" @click="deleteStep(index)">
              <icon icon="trash"/>
            </div>
          -->
        </div>
      </div>
      <auto-textarea v-model="step.desc" :placeholder="placeholder"/>
      <photo-uploader v-model="step.photo" type="single"/>
    </div>


    <button class="link" @click="addStep">
      <icon icon="new" size="tiny"/>
      <span>Добавить шаг</span>
    </button>
  </div>
</template>
<script>

export default {
  props: ['modelValue', 'placeholder'],
  data() {
    return {
     steps: this.modelValue,
    }
  },
  watch: {

  },
  computed: {

  },
  mounted() {
   
  },
  methods: {
    addStep() {
      if(this.steps) {
        if(this.steps.length <= 14) {

          let x = {
            desc: '',
            photo: null
          }

          this.steps.push(x)

        }
      }
    },
    deleteStep(index) {
      console.log(this.steps[index])
      let filteredSteps = _.filter(this.steps, (step) => {
        return step != this.steps[index]
      })
      this.steps = filteredSteps
      this.$emit('update:modelValue', filteredSteps);
      console.log(filteredSteps)
    }
  },
};
</script>
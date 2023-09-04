<template>
  <div class="time-input">
    <input v-model="hours" type="number" placeholder="Часы">
    <input v-model="minutes" type="number" placeholder="Минуты">
  </div>
</template>
<script>

export default {
  props: ['checked'],
  data() {
    return {
      hours: null,
      minutes: null,
      time: null
    }
  },
  watch: {
    hours() {
      this.time = {
        hours: this.hours,
        minutes: this.minutes
      }
      this.$emit('update:modelValue', this.time);
    },
    minutes() {
      this.time = {
        hours: this.hours,
        minutes: this.minutes
      }
      this.$emit('update:modelValue', this.time);
    }
  }
};
</script>
<style>

.time-input {
  display: inline-flex;
  width: 100%;
  gap: 8px;
}

.time-input input {
  width: 50%;
}

</style>
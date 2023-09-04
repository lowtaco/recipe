<template>
  <div class="page fullscreen">

    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$emit('goBack')"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <h1>{{ title }}</h1>
      </div>
    </div>

    <div class="page-content">
      <div class="page-wrapper">
        <input v-model="input" type="text" placeholder="Начните вводить название" @keyup="filterOptions">
        <div class="select-options">
          <div class="select-option" v-for="(option, index) in options" @click="selectOption(index)">
            <span>{{ option.name }}</span>
          </div>
        </div>
      </div>
    </div>

    <loader v-if="loading"/>

  </div>    
</template>
<script>

export default {
  props: ['request', 'title'],
  data() {
    return {
      input: null,
      options: null,
      loading: false
    }
  },
  mounted() {
    this.getItems()
  },
  methods: {
    getItems() {
      if(this.request) {
        this.loading = true
        axios.get(this.request).then((response) => {
          this.options = response.data;
          this.backup = this.options;
          this.loading = false
        })
      }
    },
    filterOptions() {
      if (this.input) {
        let filteredOptions = _.filter(this.options, (option) => {
          if (_.includes(option.name.toLowerCase(), this.input.toLowerCase())) {
            return option;
          }
        });
        this.options = filteredOptions;
      } else {
        this.options = this.backup;
      }
    },
    selectOption(index) {
      this.$emit('selectOption', this.options[index]);
      this.$emit('goBack');
    }
  }
};
</script>
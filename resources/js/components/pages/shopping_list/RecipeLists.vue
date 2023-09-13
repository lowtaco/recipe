<template>
  <div class="page shopping-list no-padding">

    <div class="page-content">
      <div class="shopping-lists-box">
        <div class="sl-item" v-for="(item, index) in lists" @click="$emit('openList', item.id)">
          <div class="sl-main">
     
            <div class="sl-picture">
              <img :src="item.picture"/>
            </div>
            <div class="sl-info">
              <span>{{ item.name }}</span>
              <a>{{ productsAmount[index] }}</a>
            </div>
          </div>

          <div class="sl-second" v-if="item.shared">
            <div class="sl-shared">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.375 7.5a5.625 5.625 0 0 1 11.25 0v5.833a.625.625 0 0 1-1.25 0V7.5a4.375 4.375 0 1 0-8.75 0v6.667a2.708 2.708 0 0 0 5.417 0V8.334a1.042 1.042 0 1 0-2.083 0v5a.625.625 0 0 1-1.25 0v-5a2.292 2.292 0 1 1 4.583 0v5.833a3.958 3.958 0 1 1-7.917 0V7.5Z" fill="black"/></svg>
            </div>
            
            <div class="sl-run">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.892 4.558a.625.625 0 0 1 .883 0l5 5a.625.625 0 0 1 0 .883l-5 5a.625.625 0 1 1-.883-.883L12.45 10 7.892 5.442a.625.625 0 0 1 0-.883Z" fill="#030D45"/></svg>
            </div>
          </div>
        </div>
      </div>

      <div class="page-empty" v-if="isListEpmty">
        <div class="pe-wrapper">
          <span>{{ $strings.pages.shopping_lists.empty.title }}</span>
          <img>
          <p>{{ $strings.pages.shopping_lists.empty.msg }}</p>
        </div>
      </div>
    </div>

  </div>
</template>
<script>

export default {
  props: ['user', 'lists'],
  data() {
    return {
      isListEpmty: null,
    }
  },
  computed: {
    isListEpmty() {
      if(this.lists) {
        if (this.lists.length == 0) {
          return true;
        } else {
          return false;
        }
      }
    },
    productsAmount() {
      if (this.lists) {
        if (this.lists.length != 0) {
          let amount = [];
          _.forEach(this.lists, (item) => {
            let jsonList = JSON.parse(item.list);
            let num = jsonList.length;
            let str = num + " " + утилиты.makeStringEnding(num, ["продукт", "продукта", "продуктов"]);
            amount.push(str);
          })
          return amount;
        }
      }
    }
  },
  mounted() {
  },
  methods: {
    openList(id) {
      console.log(this.lists);
      console.log(id);
      this.$emit('openList', id);
    }
  },
};
</script>
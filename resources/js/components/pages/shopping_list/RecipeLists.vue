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

          <div class="sl-second">
            <div class="sl-shared" v-if="item.shared">
              <icon icon="shared"/>
            </div>
            
            <div class="sl-run">
              <icon icon="run" />
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
      this.$emit('openList', id);
    }
  },
};
</script>
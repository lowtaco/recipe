<template>
  <div class="popup-close" @click="$emit('goBack')">
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.523 3.523a.645.645 0 0 1 .912 0L10 9.088l5.565-5.565a.645.645 0 1 1 .912.912L10.913 10l5.565 5.565a.645.645 0 1 1-.912.912L10 10.913l-5.565 5.565a.645.645 0 1 1-.912-.912L9.088 10 3.523 4.435a.645.645 0 0 1 0-.912Z" fill="#030D45"/></svg>
    <span>Отмена</span>
  </div>
  <input v-model="itemName" type="text" :maxlength="maxItemName" placeholder="Название продукта" @keydown="inputChanged">
  <div class="two-collumns">
    <div class="item">
      <input v-model="itemAmount" type="number" placeholder="Количество" @keydown="AmountInputChanged">
    </div>
    <div class="item">
      <r-select v-model="itemUnit" request="/get-ingredients-units" placeholder="Ед. измерения"/>
    </div>
  </div>
  <button class="big" @click="addItem"><span>Добавить продукт</span></button>
</template>
<script>

export default {
  props: ['list'],
  data() {
    return {
      itemName: null,
      itemAmount: null,
      itemUnit: null,
      maxItemName: 14,
      maxAmount: 6,
      maxUnit: 14,
      template: {
        "name": "",
        "amount": null,
        "unit": null,
        "checked": false
      },
    }
  },
  methods: {
    AmountInputChanged() {
      if(this.itemAmount) {
        if(String(this.itemAmount).length >= this.maxAmount ) {
          this.itemAmount = Number(String(this.itemAmount).slice(1, this.maxAmount))
        }
      }
    },
    inputChanged() {

    },
    addItem() {
      if(this.itemName) {
        let item = _.clone(this.template);
        item.name = this.itemName;
        item.amount = this.itemAmount;
        item.unit = this.itemUnit;
        this.list.push(item);
        this.$emit('update');
      } 
    }
  },
};
</script>
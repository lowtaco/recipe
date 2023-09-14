<template>
  <div class="page add-shopping-list">

    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$router.back()">
          <icon icon="back"/>
        </div>
        <h1>Редактировать список</h1>
      </div>
    </div>

    <div class="page-content">
      <loader v-if="loading"/>
      <div class="addList">
        <div class="add-list-preview">
          <div class="sl-icon" :style="{'background-color': c_bg_color}"><span>{{ c_icon }}</span></div>
          <div class="input-with-count">
            <input v-model="listName" type="text" :class="{error: isErrorEmpty}" :maxlength="maxName" placeholder="Название списка" @keydown="inputChanged">
          </div>
        </div>
        <div class="divider simple"><span>Выберите иконку</span></div>
        <div class="item-icon-picker">
          <div class="iip-icon" :class="{selected: c_icon == icon}" v-for="icon in $addListVariables.icons" @click="c_icon = icon"><span>{{ icon }}</span></div>
        </div>
        <div class="divider simple"><span>Выберите цвет</span></div>
        <div class="item-color-picker">
          <div class="icp-color" :style="{'background-color': color}" :class="{selected: c_bg_color == color}" v-for="color in $addListVariables.colors" @click="c_bg_color = color"></div>
        </div>
      </div>
    </div>

    <div class="page-footer">
      <button class="big" @click="updateListInfo">Сохранить</button>
    </div>

  </div>
</template>
<script>

export default {
  props: ['id'],
  data() {
    return {
      loading: true,
      listName: '',
      maxName: 18,
      c_bg_color: '',
      c_icon: '📃',
      isErrorEmpty: false,
    }
  },
  mounted() {
    this.getList()
  },
  methods: {
    getList() {
      this.loading = true;
      axios.post('/get-list-info', {id: this.id}).then((response) => {
        let listInfo = response.data[0];
        this.listName = listInfo.name;
        this.c_bg_color = listInfo.color;
        this.c_icon = listInfo.icon;
        this.loading = false;
      })
    },
    updateListInfo() {
      this.loading = true;
      axios.post('/update-list-info', {
        id: this.id,
        name: this.listName,
        color: this.c_bg_color,
        icon: this.c_icon
      }).then((response) => {
        console.log("Список сохранен");
        this.$router.push('/list/' + this.id)
        this.loading = false;
      })
    }
  },
};
</script>
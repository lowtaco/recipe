<template>
  <div class="page add-shopping-list">

    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$router.push('/shopping-lists')"><icon icon="back"/></div>
        <h1>Новый список покупок</h1>
      </div>
    </div>

    <div class="page-content">
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
      <button class="big" @click="createList">Создать</button>
    </div>

  </div>
</template>
<script>

export default {
  props: ['user'],
  data() {
    return {
      listName: '',
      maxName: 18,
      c_bg_color: '#D72638',
      c_icon: '📃',
      isErrorEmpty: false,
      template: {
        "name": '',
        "type": 'personal',
        "bg_color": '',
        "icon": '',
         "list": []
      }
    }
  },
  computed: {

  },
  mounted() {
  },
  methods: {
    inputChanged() {
    },
    createList() {
      if(this.listName) {
        let list = this.template;
        list.name = this.listName;
        list.bg_color = this.c_bg_color;
        list.icon = this.c_icon;

        axios.post('/create-shopping-list', {
          user: this.user.id,
          name: this.listName,
          personal: 1,
          color: this.c_bg_color,
          icon: this.c_icon,
          list: JSON.stringify([])
        }).then((response) => {
          let id = response.data;
          this.$router.push('/list/' + id)
        })

      } else {
        this.isErrorEmpty = true;
        setInterval(() => {
          this.isErrorEmpty = false;
        }, 2000);
      }
    }
  },
};
</script>
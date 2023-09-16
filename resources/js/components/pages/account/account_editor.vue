<template>
  <div class="page registration">
    
    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$router.push('/account')"><icon icon="back" size="small"/></div>
        <h1>Редактировать профиль</h1>
      </div>
    </div>

    <div class="page-content">
      <loader v-if="loading"/>
      <div class="page-wrapper">
        <photo-uploader v-model="newAvatar" type="avatar" path="recipes"/>
        <span>Имя</span>
        <input v-model="user.first_name" type="text" placeholder="Имя">
        <span>Фамилия</span>
        <input v-model="user.last_name" type="text" placeholder="Фамилия">
        <span>Никнейм</span>
        <input v-model="user.nickname" type="text" placeholder="Никнейм">
        <span>Напишите о себе</span>
        <auto-textarea v-model="user.bio" placeholder="Биография"/>
        <span>Сайт</span>
        <input v-model="user.site" type="text" placeholder="веб-сайт">
        <span>Email (нельзя изменить)</span>
        <input v-model="user.email" type="text" placeholder="email" disabled>
        <button @click="updateUser">Сохранить</button>
      </div>
    </div>

  </div>
</template>
<script>

export default {
  props: ['user'],
  data() {
    return {
      newAvatar: null,
      loading: false,
    }
  },
  mounted() {
    if(this.user) {
      this.newAvatar = this.user.picture
    }
  },
  methods: {
    updateUser() {
      this.loading = true;
      axios.post('/upload-image', {
        image: this.newAvatar,
        type: утилиты.decodeImageType(this.newAvatar),
        folder: 'users_avatars',
        name: this.user.id
      }).then((avatar_url) => {
        axios.post('/updateUserInfo', {
          user_id: this.user.id,
          first_name: this.user.first_name,
          last_name: this.user.last_name,
          nicakname: this.user.nickname,
          bio: this.user.bio,
          site: this.user.site
        }).then((response) => {
          localStorage.setItem('user', JSON.stringify(this.user));
          this.loading = false;
          this.$router.push('/account')
        })
      })
    }
  }
};
</script>
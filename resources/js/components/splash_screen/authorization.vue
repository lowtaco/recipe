<template>
  <div class="page auth" v-if="!registrationMode">
    
    <div class="page-header">
      <h1>{{ $strings.pages.authorization.title }}</h1>
    </div>

    <div class="page-content">
      <div class="authorization">
        <div class="a-description">
          <h4>{{ $strings.pages.authorization.description.title }}</h4>
          <p>{{ $strings.pages.authorization.description.msg }}</p>
        </div>
        <div class="google-auth-btn">
          <GoogleSignIn :callback="callback"/>
        </div>
      </div>
    </div>

    <div class="debug" style="display: flex; flex-direction: column;">
      <span>Debug Login</span>
      <input type="text" v-model="debEmail" placeholder="email">
      <button @click="writeDebug">Login in Debug Mode</button>
    </div>

  </div>

  <div class="page registration" v-if="registrationMode">
    
    <div class="page-header">
      <h1>Регистрация</h1>
    </div>

    <div class="page-content">
      <div class="page-wrapper">

        <span>Имя</span>
        <input v-model="registration.first_name" type="text" placeholder="first_name">
        <span>Фамилия</span>
        <input v-model="registration.last_name" type="text" placeholder="last_name">
        <span>Придумайте псевдоним</span>
        <input v-model="registration.nickname" type="text" placeholder="nickname">
        <button @click="registerUser">Сохранить</button>
      </div>
    </div>

  </div>
</template>
<script>

export default {
  data() {
    return {
      user: {
        email: "",
        name: "",
        picture: ""
      },
      registration: {
        nickname: '',
        first_name: '',
        last_name: '',
        picture: null
      },
      registrationMode: false,
      token: null,
      debEmail: ''
    }
  },
  methods: {
    callback(response) {
      if(response.credential) {
        // Если авторизация успешна, декодируем JWT токен
        this.token = response.credential;
        const userInfo = утилиты.decodeJwt(response.credential);

        // Переносим нужную информацию в объект User
        this.user.email = userInfo.email;
        this.user.name = userInfo.given_name + " " + userInfo.family_name;
        this.user.picture = userInfo.picture;
        
        this.authorize(userInfo.email, userInfo);
      }
    },
    authorize(email, userInfo) {
      axios.post('/auth', {
        email: email
      }).then((response) => {
        if(response.data[0]) {
          // Записываем токен и информацию о пользователе в localStorage
          localStorage.setItem('token', this.token)
          localStorage.setItem('user', JSON.stringify(response.data[0]))
          location.reload();
        } else {
          // Открываем регистрацию
          if(userInfo) {
            this.registration.first_name = userInfo.given_name;
            this.registration.last_name = userInfo.family_name;
          }
          this.registrationMode = true;
        }
      })
    },
    registerUser() {
      axios.post('/registration', {
        nickname: this.registration.nickname,
        email: this.user.email,
        first_name: this.registration.first_name,
        last_name: this.registration.last_name,
        picture: this.user.picture,
      }).then(() => {
        this.authorize(this.user.email);
      })
    },
    writeDebug() {
      this.user.email = this.debEmail;
      this.token = 'debug'
      this.authorize(this.debEmail)
    }
  },
};
</script>
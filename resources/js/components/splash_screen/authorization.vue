<template>
  <div class="page auth" v-if="!registrationMode" v-touch:hold="debugModeSwitcher">

    <div class="page-content">
      <div class="authorization">
        <div class="a-description">
          <p>{{ $strings.pages.authorization.description.msg }}</p>
        </div>
        <div class="google-auth-btn">
          <GoogleSignIn :callback="googleCallback"/>
        </div>
      </div>
    </div>

    <div v-if="debugMode" class="debug" style="display: flex; flex-direction: column; gap: 8px; scale: 1;">
      <input type="text" v-model="debEmail" placeholder="email">
      <button @click="writeDebug">Login in Debug Mode</button>
    </div>

  </div>

  <div class="page registration" v-if="registrationMode">
    
    <div class="page-header no-border">
      <div class="header-w-button">
        <div class="goBackButton" @click="$router.back()"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M9.578 17.137a.625.625 0 0 1-.882-.058l-5.833-6.667a.625.625 0 0 1 0-.823l5.833-6.667a.625.625 0 1 1 .94.823l-4.925 5.63h11.956a.625.625 0 0 1 0 1.25H4.711l4.926 5.63a.625.625 0 0 1-.058.882Z" fill="#030D45"/></svg></div>
        <h1>Регистрация</h1>
      </div>
    </div>

    <div class="page-content">
      <div class="page-wrapper">
        <photo-uploader v-model="registration.picture" type="avatar" path="recipes"/>
        <span>Имя</span>
        <input v-model="registration.first_name" type="text" placeholder="Ваше имя">
        <span>Фамилия</span>
        <input v-model="registration.last_name" type="text" placeholder="Ваша фамилия">
        <span>Придумайте псевдоним</span>
        <input v-model="registration.nickname" type="text" placeholder="Придумайте никнейм">
        <button @click="registerUser">Сохранить</button>
      </div>
    </div>

  </div>

</template>
<script>
import axios from 'axios';

export default {
  data() {
    return {
      debugMode: false,
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
    debugModeSwitcher() {
      this.debugMode = !this.debugMode
    },
    googleCallback(response) {
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

    async authorize(email, userInfo) {
      try {
        const response = await axios.post('/auth', {email: email})
        if(response.data[0]) {
          // Записываем токен и информацию о пользователе в localStorage
          localStorage.setItem('token', this.token)
          localStorage.setItem('user', JSON.stringify(response.data[0]))
          this.$emit('authorized', this.token, response.data[0]);
          this.$router.push('/')
        } else {
          // Открываем регистрацию
          if(userInfo) {
            this.registration.first_name = userInfo.given_name;
            this.registration.last_name = userInfo.family_name;
            this.registration.picture = userInfo.picture;
          }
          this.registrationMode = true;
        }
      } catch (e) {
        console.log(e)
      }
    },

    async registerUser() {
      try {
        const user_id = await axios.post('/registration', {
          nickname: this.registration.nickname,
          email: this.user.email,
          first_name: this.registration.first_name,
          last_name: this.registration.last_name,
        })
        const avatar_url = await axios.post('/upload-image', {
          image: this.registration.picture,
          type: утилиты.decodeImageType(this.registration.picture),
          folder: 'users_avatars',
          name: user_id.data
        })
        await axios.post('/updateUserAvatar', {
          user_id: user_id.data,
          picture: avatar_url.data
        }).then(() => {
          this.authorize(this.user.email);
        })
      } catch (e) {
        console.log(e)
      }
    },
    writeDebug() {
      this.user.email = this.debEmail;
      this.token = 'debug'
      this.authorize(this.debEmail)
    }
  },
};
</script>
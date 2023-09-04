<template>
  <authorization />
</template>
<script>

import authorization from './authorization'

export default {
  components: {
    authorization
  },
  data() {
    return {
      user: {
        email: "",
        name: "",
        picture: ""
      },
      debEmail: '',
      debName: '',
      debLastName: ''
    }
  },
  methods: {
  },
};
</script>
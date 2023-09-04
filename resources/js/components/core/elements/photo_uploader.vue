<template>
  <div class="photo-uploader-single" v-if="type == 'single'">

    <div class="uploader-form" v-if="!preview">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" style="enable-background:new 0 0 473.931 473.931" xml:space="preserve" width="64" height="64"><path style="fill:#357180" d="M64 32a32 32 0 0 1-32 32A32 32 0 0 1 0 32a32 32 0 0 1 64 0z"/><path transform="rotate(-99.073 237.029 240.88)" style="fill:#ebf6f9" d="M17.484 12.451h29.049v40.156H17.484V12.451z"/><path style="fill:#dbf0f5" d="M53.023 42.334 15.447 48.52l-4.26-26.103 37.577-6.185Z"/><path style="fill:#6cc077" d="m51.834 37.737-5.922-4.247s-1.766-1.637-3.106-1.339c-1.206.271-2.378 2.03-2.599 2.376l-1.985-1.424s-2.07-1.921-3.64-1.569c-1.571.351-3.102 2.873-3.102 2.873l-.435.606-3.736-2.682s-2.543-2.36-4.473-1.929c-1.931.431-3.813 3.531-3.813 3.531l-4.51 6.287 1.295 7.841 36.727-6.046-.702-4.277z"/><path style="fill:#67b8cb" d="M33.336 25.538c-.002-.043.021-.084.011-.128-.11-.669-.922-1.091-1.813-.946-.117.019-.215.07-.324.104-.325-.31-.854-.48-1.437-.385-.755.124-1.288.633-1.341 1.193-.71.266-1.183.835-1.085 1.431.093.564.661.947 1.364 1.008.314.477 1.002.75 1.763.625.69-.114 1.224-.518 1.427-1.003a1.841 1.841 0 0 0 .593-.001c.791-.13 1.353-.717 1.256-1.311-.041-.243-.204-.438-.416-.589zm7.795.279c-.011-.029-.035-.052-.04-.083-.078-.474.373-.946 1.006-1.05.084-.013.161-.003.241-.003.148-.285.467-.519.879-.587.538-.089 1.012.133 1.177.496.538.018.986.293 1.055.717.066.401-.231.787-.688.989-.102.392-.504.733-1.044.822-.49.081-.943-.071-1.19-.349a1.321 1.321 0 0 1-.399.134c-.563.093-1.075-.174-1.144-.596-.03-.173.036-.341.147-.491z"/><path style="fill:#0ea24a" d="M56.586 40.544a8.376 8.376 0 0 1-8.377 8.376 8.376 8.376 0 0 1-8.376-8.376 8.376 8.376 0 0 1 16.753 0z"/><path style="fill:#fff" d="M47.199 36.194h2.562V45.1h-2.562v-8.906z"/><path style="fill:#fff" d="M44.026 39.367h8.906v2.562h-8.906v-2.562z"/></svg>
        
        <label class="file-uploader">
          <input type="file" accept="image/jpeg, image/jpg, image/png" @change=uploadImage>
          <div class="button">
            <icon icon="img" size="tiny"/>
            <span>Выберите фото</span>
          </div>
        </label>

      <p>Используйте только уникальные фотографии. Формат JPG, JPEG, PNG. Размер до 20мб.</p>
    </div>

    <div class="preview" v-if="preview">
      <div class="preview-buttons">
        <div class="item" @click="removeImage">
          <icon icon="trash"/>
        </div>
      </div>

      <img :src="previewImage" class="uploading-image">
    </div>
    
  </div>

  <div class="photo-uploader-multiply" v-if="type == 'multiply'">

    <input style="display: block;" type="file" multiple="multiple" accept="image/jpeg, image/jpg, image/png" @change=uploadImage>


  </div>
</template>
<script>


export default {
  props: ['type'],
  data(){
    return{
      preview: false,
      previewImage:null
    }
  },
  methods: {
    uploadImage(e){
      const image = e.target.files[0];
      
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
          this.previewImage = e.target.result;
          this.preview = true
          this.$emit('update:modelValue', e.target.result)
      };
      
    },
    removeImage() {
      this.previewImage = null
      this.preview = false
      this.$emit('update:modelValue', null)
    }
  }
};
</script>

<style>

.photo-uploader-single {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 300px;
  background-color: #eaeaea;
  border-radius: 20px;
  overflow: hidden;
}

.uploader-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 16px;
  width: 100%;
  height: 100%;
}

.uploader-form  p {
  text-align: center;
  font-size: 14px;
  padding: 0 28px;
}

.preview {
  position: relative;
  display: flex;
  flex-direction: column;
  width: 100%;
  height: 100%;
}

.preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.preview-buttons {
  position: absolute;
  display: inline-flex;
  flex-direction: row-reverse;
  width: 100%;
  padding: 10px;
  box-sizing: border-box;

  .item {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    padding: 5px;
  }
}

.preview-buttons svg path {
  fill: white;
}

</style>
<template>
  <div v-if="message && showMessage" class="alert alert-success" role="alert">
    {{ message }}
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      showMessage: true
    };
  },
  mounted() {
    if (this.message) {
      setTimeout(() => {
        this.showMessage = false;
      }, 3000); // Menghilangkan pesan setelah 3 detik
    }
  }
};
</script>

<style scoped>
.alert {
  padding: 10px;
  margin-top: 20px;
  border-radius: 5px;
  background-color: #d4edda;
  color: #155724;
}
</style>

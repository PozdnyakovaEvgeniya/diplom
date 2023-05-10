<template>
  <div class="header">
    <h1>{{ name }}</h1>
    <div class="user">
      <router-link to="/account/:id">Иванов И.И.</router-link>      
      <button>Выйти</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: String,
  },
};
</script>

<style scoped>
.header {
  max-width: 100%;
  padding: 20px;
  border-bottom: 2px solid var(--grey);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.user {
  display: flex;
  gap: 10px;
  align-items: center;
}

button {
  padding: 5px 10px;
}
</style>

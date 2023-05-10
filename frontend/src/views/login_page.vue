<template>
  <div class="login_page">
    <form class="form" @submit="login">
      <h4>Вход в систему</h4>
      <div class="form-field">
        <span>Логин</span>
        <input type="text" v-model="number" />
      </div>
      <div class="form-field">
        <span>Пароль</span>
        <input v-model="password" />
      </div>
      <div class="form-button">
        <button @click="login">Войти</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      number: "",
      password: "",
    };
  },

  methods: {
    login(e) {
      e.preventDefault();
      let serchParams = new URLSearchParams();

      serchParams.set("number", this.number);
      serchParams.set("password", this.password);
      fetch("http://localhost/api/employee/login.php", {
        method: "POST",
        body: serchParams,
      }).then((response) => {
        console.log(response);
      });
    },
  },
};
</script>

<style>
  .login_page {
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--blackout);
  }
</style>

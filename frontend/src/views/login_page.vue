<template>
  <div class="login_page">
    <form class="form" @submit="login">
      <h4>Вход в систему</h4>
      <div class="error">{{ error }}</div>
      <div class="form-field">
        <span>Логин</span>
        <input type="text" v-model="number" />
      </div>
      <div class="form-field">
        <span>Пароль</span>
        <input type="password" v-model="password" />
      </div>
      <div class="form-button">
        <button>Войти</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      number: "",
      password: "",
      now: new Date(),
      error: "",
      user: "",
    };
  },

  methods: {
    async login(e) {
      e.preventDefault();
      await axios
        .post("http://localhost/api/employee/login.php", {
          number: this.number,
          password: this.password,
        })
        .then((response) => {
          this.error = "";
          localStorage.setItem("token", response.data.token);
          this.getUser();
        })
        .catch((error) => {
          console.log(error);
          this.error = error.response.data.message;
        });
    },

    async getUser() {
      await axios
        .post("http://localhost/api/employee/getUser.php", {
          token: localStorage.getItem("token"),
        })
        .then((response) => {
          if (response.data.status == 1) {
            this.$router.replace({
              name: "timesheet",
              params: {
                year: this.now.getFullYear(),
                month: this.now.getMonth(),
              },
            });
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.login_page {
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: var(--blackout);
}

.form {
  box-shadow: 0 6px 15px var(--black);
}
</style>

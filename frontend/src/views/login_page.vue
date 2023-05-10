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
      now: new Date(),
      error: "",
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
      })
        .then((response) => {
          return response.json();
        })
        .then((json) => {
          if (json.message == "success") {
            this.setCookie("jwt", json.jwt, 1);
            this.$router.push({
              name: "department",
              params: {
                year: this.now.getFullYear(),
                month: this.now.getMonth(),
              },
            });
          } else {
            this.error = json.message;
          }
        });
    },

    setCookie(cname, cvalue, exdays) {
      let now = new Date();
      now.setTime(now.getTime() + exdays * 24 * 69 * 60 * 1000);
      let expires = "expires=" + now.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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

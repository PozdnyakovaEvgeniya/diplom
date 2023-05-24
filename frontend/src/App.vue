<template>
  <div class="wrapper">
    <div v-if="$route.path != '/login'" class="main-nav">
      <h4>{{ now.getFullYear() }} год</h4>
      <router-link
        v-for="(month, index) in months"
        :key="index"
        :to="setPath(now.getFullYear(), index)"
        :class="setClass(now.getFullYear(), index)"
      >
        {{ month }}
      </router-link>
    </div>
    <router-view class="container" :key="$route.path"></router-view>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      now: new Date(),
      months: [
        "Январь",
        "Февраль",
        "Март",
        "Апрель",
        "Май",
        "Июнь",
        "Июль",
        "Август",
        "Сентябрь",
        "Октябрь",
        "Ноябрь",
        "Декабрь",
      ],
    };
  },

  methods: {
    setClass(year, month) {
      if (year == this.now.getFullYear() && month == this.now.getMonth()) {
        return "now";
      }
    },

    setPath(year, month) {
      let params = { year, month };
      if (this.$route.params.id) {
        params.id = this.$route.params.id;
      }
      return this.$route.name
        ? {
            name: this.$route.name,
            params,
          }
        : `/timekeeper-main/${year}/${month}/department`;
    },

    async getUser() {
      await axios
        .post("http://localhost/api/employees/getUser.php", {
          token: localStorage.getItem("token"),
        })
        .then((response) => {
          if (response.data.id == 1) {
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

  beforeCreate() {
    if (!localStorage.getItem("token")) {
      this.$router.replace("/login");
    }
  },

  created() {
    this.getUser();
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Montserrat", sans-serif;
  font-size: 16px;
}

#app {
  width: 100vw;
  height: 100vh;
  background: linear-gradient(90deg, var(--white), var(--grey));
  overflow: hidden;
}

:root {
  --grey: #e6e6fa;
  --white: #ffffff;
  --purple: #9999f8;
  --black: #000000;
  --blackout: #f5f5f5b3;
}

a {
  color: inherit;
  text-decoration: none;
  width: max-content;
  height: min-content;
}

h1 {
  font-size: 30px;
  color: var(--purple);
}

h4 {
  font-size: 18px;
}

button {
  background: var(--purple);
  color: var(--white);
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}

input {
  background: var(--grey);
  border-radius: 5px;
  border: none;
  outline: none;
  padding: 2px 5px;
  width: 40px;
}

.form-field input {
  padding: 10px 20px;
  width: 350px;
}

.wrapper {
  width: 100vw;
  height: 100vh;
  display: grid;
  grid-template-columns: 125px calc(100% - 125px);
  border-radius: 22px;
  border: 2px solid var(--grey);
}

.main-nav {
  height: 100%;
  overflow-y: auto;
  padding: 20px 0;
  display: grid;
  align-content: flex-start;
  background: var(--grey);
  border-radius: 20px 0 0 20px;
  border-right: 2px solid var(--grey);
}

.main-nav h4 {
  padding: 10px 20px;
}

.main-nav a {
  width: 100%;
  padding: 10px 20px;
  border: 1px solid var(--grey);
}

.main-nav a:hover,
.main-nav .router-link-active {
  background: var(--white);
  border-radius: 5px;
}

.main-nav a.now {
  font-weight: 600;
}

.container {
  border-radius: 0 20px 20px 0;
  background: var(--white);
}

.content-header {
  padding-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 20px;
}

.content {
  padding: 20px;
  height: calc(100% - 150px);
}

.content-bottom {
  display: flex;
  justify-content: space-between;
  padding: 0 20px 20px;
  align-items: center;
}

.form {
  border-radius: 5px;
  padding: 40px 50px;
  display: grid;
  gap: 20px;
  background: var(--white);
}

.form-field {
  display: grid;
  gap: 5px;
}

.form-field span {
  font-size: 13px;
}

.form-button {
  display: flex;
  justify-content: flex-end;
}

.error {
  color: red;
}

.nav {
  border-bottom: 2px solid var(--grey);
  display: flex;
}

.nav a {
  display: block;
  padding: 20px;
  border: 1px solid var(--white);
}

.nav a:hover,
.nav .router-link-active {
  background: var(--grey);
}
</style>

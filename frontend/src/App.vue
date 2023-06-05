<template>
  <div class="wrapper">
    <div v-if="$route.path != '/login'" class="main-nav">
      <template v-if="this.user.status == 1">
        <h4>{{ now.getFullYear() }} год</h4>
        <router-link
          v-for="(month, index) in months"
          :key="index"
          :to="setPath(now.getFullYear(), index)"
          :class="setClass(now.getFullYear(), index)"
        >
          {{ month }}
        </router-link>
      </template>
      <template v-else-if="this.user != [] && this.user.status == 2">
        <h4>Отделы</h4>
        <router-link
          v-for="department in departments"
          :key="department.id"
          :to="{ name: 'employees', params: { department_id: department.id } }"
        >
          {{ department.name }}
        </router-link>
      </template>
    </div>
    <router-view class="container"></router-view>
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
      user: {},
      departments: [],
    };
  },

  methods: {
    async getDepartments() {
      await axios
        .get("http://localhost/api/departments/get.php")
        .then((response) => {
          this.departments = response.data;
        });
    },

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
          this.user = response.data;
          if (response.data.status == 2) {
            this.getDepartments();
          }
        })
        .catch(() => {
          this.logout();
        });
    },

    async logout() {
      await axios
        .post(`http://localhost/api/employees/logout.php`, {
          token: localStorage.getItem("token"),
        })
        .then(() => {
          localStorage.removeItem("token");
          this.$router.push("/login");
        });
    },
  },

  beforeCreate() {
    if (!localStorage.getItem("token")) {
      this.$router.replace("/login");
    }
  },

  watch: {
    $route() {
      this.getUser();
    },
  },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>

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
  --purple: #8888e7;
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
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 400;
}

input:not([type="checkbox"]) {
  background: var(--grey);
  border-radius: 5px;
  border: none;
  outline: none;
  padding: 2px 5px;
  width: 40px;
}

.multiselect,
.multiselect.is_active {
  background: var(--grey);
  border: 1px solid var(--grey) !important;
}

.multiselect-option.is-selected,
.multiselect-option.is-selected.is-pointed,
.multiselect-option.is-pointed,
.multiselect-option:hover {
  background: var(--grey);
  color: initial;
}

.multiselect li {
  margin: 0;
}

ol {
  margin: 20px;
}

li {
  margin: 10px 0;
}

.form-field input:not([type="checkbox"]) {
  padding: 10px 20px;
  width: 450px;
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
  font-size: 14px;
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
  width: max-content;
  border-radius: 5px;
  padding: 40px 50px;
  display: grid;
  gap: 20px;
  background: var(--white);
  border: 1px solid var(--grey);
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
  border-radius: 5px;
}
</style>

<template>
  <div class="header">
    <h1>{{ department }}</h1>
    <div class="user">
      <span class="name">{{ short_name }}</span>
      <span class="job_title">{{ job_title }}</span>
      <div class="dropdown">
        <div>Сменить пароль</div>
        <div @click="logout">Выйти</div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    name: String,
  },

  data() {
    return {
      short_name: "",
      job_title: "",
      department: "",
    };
  },

  async created() {
    let jwt = localStorage.getItem("jwt");

    await axios
      .post("http://localhost/api/employee/validate_token.php", { jwt })
      .then((response) => {
        this.short_name = response.data.user.short_name;
        this.job_title = response.data.user.job_title;

        axios
          .get(
            `http://localhost/api/department/read_one.php?id=${response.data.user.department_id}`
          )
          .then((response) => {
            console.log(response.data);
            this.department = response.data.name;
          });
      });
  },

  methods: {
    logout() {
      localStorage.removeItem("jwt");
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped>
.header {
  max-width: 100%;
  padding: 10px 20px;
  border-bottom: 2px solid var(--grey);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.user {
  display: grid;
  justify-items: center;
  gap: 10px;
  padding: 5px 15px;
  border-radius: 5px;
  position: relative;
}

.name {
  font-weight: 600;
}

.job_title {
  font-size: 14px;
}

.user .dropdown {
  display: none;
  position: absolute;
  top: 56px;
  left: -10px;
  z-index: 9;
  background: var(--grey);
  width: calc(100% + 20px);
  border-radius: 5px;
  border: 1px solid var(--grey);
}

.user:hover .dropdown {
  display: grid;
}

.user .dropdown > div {
  padding: 5px 15px;
  cursor: pointer;
  font-size: 14px;
}

.user .dropdown > div:hover {
  background: var(--white);
  border-radius: 5px;
}
</style>

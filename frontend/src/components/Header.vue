<template>
  <div class="header">
    <h1>{{ department.name }}</h1>
    <div class="user">
      <span class="name">{{ user.short_name }}</span>
      <span class="job_title">{{ user.job_title }}</span>
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
  data() {
    return {
      user: {},
      department: {},
    };
  },

  async created() {
    this.getUser().then(() => this.getDepartment());
  },

  methods: {
    async getUser() {
      await axios
        .post("http://localhost/api/employees/getUser.php", {
          token: localStorage.getItem("token"),
        })
        .then((response) => {
          this.user = response.data;
        })
        .catch(() => {
          this.logout();
        });
    },

    async getDepartment() {
      await axios
        .get(
          `http://localhost/api/departments/getOne.php?id=${this.user.department_id}`
        )
        .then((response) => {
          this.department = response.data;
        })
        .catch((error) => {
          console.log(error);
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

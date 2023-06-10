<template>
  <div class="header">
    <Modal :show="modalUpd" @close="closeUpd">
      <form class="form" @submit.prevent="updatePassword">
        <h4>Изменить пароль</h4>
        <div class="error">{{ error }}</div>
        <div class="form-field">
          <span>Текущий пароль</span>
          <input type="password" v-model="password_old" />
        </div>
        <div class="form-field">
          <span>Новый пароль</span>
          <input type="password" v-model="password_new" />
        </div>
        <div class="form-field">
          <span>Подтверждение пароля</span>
          <input type="password" v-model="password_confirm" />
        </div>
        <div class="form-button">
          <button>Изменить</button>
        </div>
      </form>
    </Modal>
    <h1>{{ name }}</h1>
    <div class="user">
      <span class="name">{{ user.short_name }}</span>
      <span class="job_title">{{ user.job_title }}</span>
      <div class="dropdown">
        <div @click="showUpd">Сменить пароль</div>
        <div @click="logoutAll">Завершить все другие сеансы</div>
        <div @click="logout">Выйти</div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Modal from "@/components/Modal.vue";

export default {
  components: {
    Modal,
  },

  props: {
    name: String,
  },

  data() {
    return {
      user: {},
      password_old: "",
      password_new: "",
      password_confirm: "",
      modalUpd: false,
      error: "",
    };
  },

  async created() {
    this.getUser();
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

    async updatePassword() {
      await axios
        .post("http://localhost/api/employees/updatePassword.php", {
          id: this.user.id,
          password_old: this.password_old,
          password_new: this.password_new,
          password_confirm: this.password_confirm,
        })
        .then((response) => {
          localStorage.setItem("token", response.data.token);
          this.closeUpd();
        })
        .catch((error) => {
          this.error = error.response.data.message;
        });
    },

    async logout() {
      await axios
        .post("http://localhost/api/employees/logout.php", {
          token: localStorage.getItem("token"),
        })
        .then(() => {
          localStorage.removeItem("token");
          this.$router.push("/login");
        });
    },

    showUpd() {
      this.modalUpd = true;
    },

    closeUpd() {
      this.password_old = "";
      this.password_new = "";
      this.password_confirm = "";
      this.error = "";
      this.modalUpd = false;
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

<template>
  <div class="header">
    <h1>{{ name }}</h1>
    <div class="user">
      <span>{{ short_name }}</span>
      <span>{{ job_title }}</span>
      <div class="dropdown">
        <div>Сменить пароль</div>
        <div @click="logout">Выйти</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: String,
  },

  data() {
    return {
      short_name: "",
      job_title: "",
    };
  },

  created() {
    let jwt = this.getCookie("jwt");

    let searchParams = new URLSearchParams();
    searchParams.set("jwt", jwt);

    fetch("http://localhost/api/employee/validate_token.php", {
      method: "POST",
      body: searchParams,
    })
      .then((response) => {
        return response.json();
      })
      .then((json) => {
        this.short_name = json.data.short_name;
        this.job_title = json.data.job_title;
      });
  },

  methods: {
    getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let cookies = decodedCookie.split(";");
      for (let cookie of cookies) {
        while (cookie.charAt(0) == " ") {
          cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name) == 0) {
          return cookie.substring(name.length, cookie.length);
        }
      }
      return "";
    },

    logout() {},
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
  gap: 10px;
  border: 1px solid var(--grey);
  padding: 5px 15px;
  border-radius: 5px;
  position: relative;
}

.user .dropdown {
  display: none;
  position: absolute;
  top: 59px;
  left: -1px;
  z-index: 9;
  background: var(--grey);
  width: calc(100% + 2px);
  border-radius: 5px;
  border: 1px solid var(--grey);
}

.user:hover .dropdown {
  display: grid;
}

.user .dropdown > div {
  padding: 5px 15px;
  cursor: pointer;
}

.user .dropdown > div:hover {
  background: var(--white);
  border-radius: 5px;
}
</style>

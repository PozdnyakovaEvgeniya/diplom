<template>
  <div class="header">
    <h1>{{ name }}</h1>
    <div class="user">Иванов И.И.</div>
  </div>
</template>

<script>
export default {
  props: {
    name: String,
  },

  created() {
    let jwt = this.getCookie("jwt");

    let searchParams = new URLSearchParams();
    searchParams.set("jwt", jwt);
    console.log(searchParams);

    fetch("http://localhost/api/employee/validate_token.php", {
      method: "POST",
      body: searchParams,
    })
      .then((response) => {
        return response.json();
      })
      .then((json) => {
        console.log(json);
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
  color: var(--purple);
}

button {
  padding: 5px 10px;
}
</style>

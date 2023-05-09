<template>
  <div class="wrapper">
    <div class="nav">
      <h4>{{ now.getFullYear() }} год</h4>
      <router-link
        v-for="(month, index) in months"
        :key="index"
        :to="'/main/' + now.getFullYear() + '/' + index"
        :class="setClass(now.getFullYear(), index)"
      >
        {{ month }}
      </router-link>
    </div>
    <router-view class="container" :key="$route.path"></router-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      now: new Date(),
      months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
    };
  },

  methods: {
    setClass(year, month) {
      if (year == this.now.getFullYear() && month == this.now.getMonth()) {
        return 'now';
      }
    }
  }
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
  background: linear-gradient(90deg, var(--white) 50%, var(--grey) 50%);
  overflow: hidden;
}

:root {
  --grey: #e6e6fa;
  --white: #ffffff;
  --purple: #9370db;
  --black: #000000;
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

button {
  background: var(--purple);
  color: var(--white);
  border: none;
  padding: 5px 10px;
  border-radius: 20px;
  cursor: pointer;
}

.wrapper {
  width: 100vw;
  height: 100vh;
  display: grid;
  grid-template-columns: 125px calc(100% - 125px);
  border-radius: 32px;
  border: 2px solid var(--grey);
}

.nav {
  height: 100%;
  overflow-y: auto;
  padding: 20px 0;
  display: grid;
  align-content: flex-start;
  background: var(--grey);
  border-radius: 30px 0 0 30px;
  border-right: 2px solid var(--grey);
}

.nav h4 {
  padding: 10px 20px;
}

.nav a {
  width: 100%;
  padding: 10px 20px;
  border: 1px solid var(--grey);
}

.nav a:hover,
.nav .router-link-active {
  background: var(--white);
  border-radius: 20px;
}

.nav a.now {
  font-weight: 600;
}

.container {
  border-radius: 0 30px 30px 0;
  background: var(--white);
}

.container a:hover {
  text-decoration: underline;
}

.content {
  padding: 20px;
}
</style>

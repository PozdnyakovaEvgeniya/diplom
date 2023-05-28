<template>
  <input @change="submit" type="text" v-model="newValue" />
</template>

<script>
import axios from "axios";

export default {
  props: {
    value: Number,
    request: String,
  },

  data() {
    return {
      newValue: this.value,
    };
  },

  methods: {
    async submit() {
      console.log(this.request + this.newValue);
      await axios.get(this.request + this.newValue);
    },
  },
};
</script>

<style scoped>
.icon {
  width: 18px;
  height: 18px;
  fill: var(--white);
}

button {
  padding: 0;
  width: 23px;
  height: 23px;
  border-radius: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

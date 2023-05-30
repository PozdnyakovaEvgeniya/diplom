<template>
  <div class="date">
    <label>
      <input @change="submit" type="checkbox" v-model="holiday" />
      Выходной
    </label>
    <label>План: <input @change="submit" type="text" v-model="day" /></label>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    values: Array,
    request: String,
  },

  data() {
    return {
      day: this.values[0],
      night: this.values[1],
      holiday: this.values[2],
    };
  },

  methods: {
    async submit() {
      await axios.get(
        this.request +
          "&day_hours=" +
          this.day +
          "&night_hours=" +
          this.night +
          "&status=" +
          (this.holiday ? 1 : 0)
      );
    },
  },
};
</script>

<style scoped>
.date {
  display: grid;
  gap: 2px;
  align-items: center;
}

label {
  display: flex;
  justify-content: space-between;
  gap: 2px;
  font-size: 13px;
  align-items: center;
}
</style>

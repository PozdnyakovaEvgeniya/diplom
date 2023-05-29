<template>
  <div class="date">
    <label>
      <input @change="submit" type="checkbox" v-model="holiday" />
      Праз.день
    </label>
    <label>День: <input @change="submit" type="text" v-model="day" /></label>
    <label>Ночь: <input @change="submit" type="text" v-model="night" /></label>
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
  gap: 2px;
  font-size: 13px;
  align-items: center;
}
</style>

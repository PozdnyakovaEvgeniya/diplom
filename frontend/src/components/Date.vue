<template>
  <div class="date">
    <label>
      <input type="checkbox" v-model="holiday" />
      Выходной
    </label>
    <label>План: <input type="text" v-model="day" /></label>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    values: Array,
    request: String,
    saved: Boolean,
  },

  data() {
    return {
      day: this.values[0],
      holiday: this.values[1],
    };
  },

  methods: {
    async submit() {
      await axios.get(
        this.request +
          "&hours=" +
          this.day +
          "&status=" +
          (this.holiday ? 1 : 0)
      );
    },
  },

  watch: {
    saved() {
      if (this.saved == true) {
        this.submit();
        this.$emit("save", false);
      }
    },
  },
};
</script>

<style scoped>
.date {
  display: grid;
  gap: 8px;
  align-items: center;
}

label {
  display: flex;
  justify-content: space-between;
  gap: 4px;
  font-size: 13px;
  align-items: center;
}
</style>

<template>
  <div :class="'hours'">
    <div class="status">Статус: {{ status }}</div>
    <div v-if="status != 'ОТ' && status != 'Б'">План: {{ values[1] }}</div>
    <div v-if="status != 'ОТ' && status != 'Б'">Факт: {{ values[2] }}</div>
    <div v-if="status != 'ОТ' && status != 'Б'">Отгул: {{ values[3] }}</div>
  </div>
</template>

<script>
export default {
  props: {
    values: Array,
  },

  data() {
    return {
      status: 0,
      now: new Date(),
    };
  },

  created() {
    this.getStatus();
  },

  methods: {
    getStatus() {
      this.status = ["Я", "В", "ОВ", "ОТ", "Б"][this.values[0]];

      if (
        this.status == "Я" &&
        this.values[4] >
          `${this.normalizeNum(this.now.getFullYear())}-${this.normalizeNum(
            this.now.getMonth() + 1
          )}-${this.normalizeNum(this.now.getDate())}`
      ) {
        this.status = "";
      }

      if (
        this.status != "ОТ" &&
        this.status != "Б" &&
        this.values[2] == 0 &&
        this.values[1] > 0
      ) {
        this.status = "НН";
      }

      if (this.status == "В" && this.values[2] > 0) {
        this.status = "РВ";
      }
    },

    normalizeNum(num) {
      if (num > 0 && num < 10) {
        return "0" + num;
      }

      return num;
    },
  },
};
</script>

<style scoped>
.hours {
  display: grid;
  gap: 8px;
  align-items: center;
  width: max-content;
}

.hours div {
  font-size: 13px;
}

.status {
  font-weight: 500;
}
</style>

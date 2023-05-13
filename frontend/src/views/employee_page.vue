<template>
  <div class="employee_page">
    <div class="content">
      <div class="content-header">
        <Back
          :to="`/main/${$route.params.year}/${$route.params.month}/department`"
        ></Back>
        <h4>Иванов Иван Иванович</h4>
      </div>
      <Table :headers="headers" :data="data"></Table>
    </div>
    <div class="content-bottom">
      <div>Доступно часов отгула: {{ overtime }}</div>
      <button>Сохранить</button>
    </div>
  </div>
</template>

<script>
import Table from "@/components/Table.vue";
import json from "@/assets/json/hours.json";
import Back from "@/components/Back.vue";

export default {
  components: {
    Table,
    Back,
  },

  data() {
    return {
      headers: [{ id: "name", name: "Часов" }],
      data: [],
      arr: ["Отработано по графику", "Переработано", "Отгул"],
      overtime: 5,
    };
  },

  created() {
    this.getDate();
    this.getData();
  },

  methods: {
    getDate() {
      let date = new Date(this.$route.params.year, this.$route.params.month, 1);

      while (this.$route.params.month == date.getMonth()) {
        let newDate =
          this.normalizeNum(date.getDate()) +
          "." +
          this.normalizeNum(date.getMonth() + 1);
        this.headers.push({ id: "date", name: newDate });
        date = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate() + 1
        );
      }
    },

    getData() {
      for (let item of this.arr) {
        let date = new Date(
          this.$route.params.year,
          this.$route.params.month,
          1
        );
        let elem = [{ id: "name", name: item }];
        let input = item == "Отгул" ? true : false;

        while (this.$route.params.month == date.getMonth()) {
          elem.push({
            id: "date",
            name: json[0].time,
            input,
            date: `${date.getFullYear()}-${this.normalizeNum(
              date.getMonth()
            )}-${this.normalizeNum(date.getDate())}`,
          });
          date = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 1
          );
        }
        this.data.push(elem);
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

<style scoped></style>

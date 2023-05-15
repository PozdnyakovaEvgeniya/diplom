<template>
  <div class="employee_page">
    <div class="content">
      <div class="content-header">
        <Back
          :to="`/main/${$route.params.year}/${$route.params.month}/department`"
        ></Back>
        <div class="employee">
          <h4>{{ employee.name }}</h4>
          <div>{{ employee.job_title }}</div>
        </div>
      </div>
      <Table :headers="headers" :data="data"></Table>
    </div>
    <div class="content-bottom">
      <div>Доступно часов отгула: {{ employee.overtime }}</div>
      <button>Сохранить</button>
    </div>
  </div>
</template>

<script>
import Table from "@/components/Table.vue";
import Back from "@/components/Back.vue";
import axios from "axios";

export default {
  components: {
    Table,
    Back,
  },

  data() {
    return {
      employee: {},
      headers: [{ id: "name", name: "Часов" }],
      data: [],
    };
  },

  created() {
    this.getEmployee().then(() => {
      this.getDate();
    });
  },

  methods: {
    async getEmployee() {
      await axios
        .get(
          `http://localhost/api/employee/getOne.php?id=${this.$route.params.id}`
        )
        .then((response) => {
          this.employee = response.data;
        })
        .then(() => {
          this.getHours();
        });
    },

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

    async getData() {
      for (let index = 0; index < 3; index++) {
        let date = new Date(
          this.$route.params.year,
          this.$route.params.month,
          1
        );
        let elem = [
          {
            id: "name",
            name: ["Отработано по графику", "Переработано", "Отгул"][index],
          },
        ];

        while (this.$route.params.month == date.getMonth()) {
          let input =
            index == 2 && date.getDay() != 6 && date.getDay() != 0
              ? true
              : false;

          let date_string = `${date.getFullYear()}-${this.normalizeNum(
            date.getMonth() + 1
          )}-${this.normalizeNum(date.getDate())}`;
          let flag = false;
          for (let hour of this.employee.hours) {
            if (hour.date == date_string) {
              elem.push({
                id: "date",
                name: [hour.hours, hour.overtime, hour.time_off][index],
                input,
                date: date_string,
              });
              flag = true;
              break;
            }
          }
          if (!flag) {
            elem.push({
              id: "date",
              name: date.getDay() == 6 || date.getDay() == 0 ? "В" : 0,
              input,
              background:
                date.getDay() == 6 || date.getDay() == 0 ? true : false,
            });
          }
          date = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate() + 1
          );
        }
        this.data.push(elem);
      }
    },

    async getHours() {
      await axios
        .get(
          `http://localhost/api/hour/getOfMonth.php?id=${
            this.$route.params.id
          }&start=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(
            +this.$route.params.month + 1
          )}-01&end=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(+this.$route.params.month + 2)}-01`
        )
        .then((response) => {
          this.employee.hours = response.data;
          this.getData();
        })
        .catch((error) => {
          console.log(error);
        });
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
.employee {
  display: grid;
  gap: 10px;
}
</style>

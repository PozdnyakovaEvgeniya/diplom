<template>
  <div class="employee_page">
    <div class="content">
      <Table
        :headers="headers"
        :data="data"
        :input="true"
      ></Table>
    </div>
  </div>
</template>

<script>
  import Table from '@/components/Table.vue';
  import json from "@/assets/json/hours.json";

  export default {
    components: {
        Table,
    },

    data() {
        return {
            headers: [{id: "name", name: "Иванов Иван Иванович"},],
            data: [], 
            arr: ["Отработано по графику", "Недоработано", "Переработано", "Отгул"]
        }
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
          let input = 
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
          let elem = [
            { id: "name", name: item },
          ];

          while (this.$route.params.month == date.getMonth()) {
            elem.push({ id: "date", name: json[0].time });
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
  }
</script>

<style scoped>

</style>
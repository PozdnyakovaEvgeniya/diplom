<template>
  <div class="shifts_page">
    <Modal :show="modalAdd" @close="closeAdd">
      <form class="form" @submit.prevent="addShift(user.department_id)">
        <h4>Добавить смену</h4>
        <div class="error">{{ error }}</div>
        <div class="form-field">
          <span>Название</span>
          <input type="text" v-model="name" />
        </div>
        <div class="form-button">
          <button>Добавить</button>
        </div>
      </form>
    </Modal>
    <div class="content">
      <div class="content-header">
        <Add @click="showAdd">Добавить смену</Add>
      </div>
      <Table
        :headers="headers"
        :data="data"
        :saved="saved"
        @update="update"
        @save="save"
      ></Table>
    </div>
    <div class="content-bottom">
      <div></div>
      <button @click="save(true)">Сохранить</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Table from "@/components/Table.vue";
import Add from "@/components/Add.vue";
import Delete from "@/components/Delete.vue";
import Modal from "@/components/Modal.vue";

export default {
  components: {
    Table,
    Add,
    Delete,
    Modal,
  },

  data() {
    return {
      user: {},
      shifts: [],
      name: "",
      error: "",
      headers: [{ id: "name", name: "Смена" }, { id: "delete" }],
      data: [],
      modalAdd: false,
      updated: false,
      saved: false,
    };
  },

  async created() {
    this.getDate();
    this.getUser().then(() => {
      this.getShifts();
    });
  },

  methods: {
    async getUser() {
      await axios
        .post("http://localhost/api/employees/getUser.php", {
          token: localStorage.getItem("token"),
        })
        .then((response) => {
          this.user = response.data;
        })
        .catch(() => {
          this.logout();
        });
    },

    async getShifts() {
      await axios
        .get(
          `http://localhost/api/shifts/getOfDepartment.php?id=${this.user.department_id}`
        )
        .then((response) => {
          this.shifts = response.data;
        })
        .then(() => {
          for (let index = 0; index < this.shifts.length; index++) {
            this.getDates(this.shifts[index].id, index);
          }
        })
        .catch(() => {
          this.logout();
        });
    },

    async getDates(id, index) {
      await axios
        .get(
          `http://localhost/api/dates/getOfMonth.php?id=${id}&start=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(
            +this.$route.params.month + 1
          )}-01&end=${this.normalizeNum(
            this.$route.params.year
          )}-${this.normalizeNum(+this.$route.params.month + 2)}-01`
        )
        .then((response) => {
          this.shifts[index].dates = response.data;
          this.getData(this.shifts[index]);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getDate() {
      let date = new Date(this.$route.params.year, this.$route.params.month, 1);

      while (this.$route.params.month == date.getMonth()) {
        let newDate =
          this.normalizeNum(date.getDate()) +
          "." +
          this.normalizeNum(date.getMonth() + 1) +
          ", " +
          ["вс", "пн", "вт", "ср", "чт", "пт", "сб"][date.getDay()];
        this.headers.push({ id: "date", name: newDate });
        date = new Date(
          date.getFullYear(),
          date.getMonth(),
          date.getDate() + 1
        );
      }
    },

    getData(shift) {
      let newDate = new Date(
        this.$route.params.year,
        this.$route.params.month,
        1
      );
      let elem = [
        { id: "id", name: shift.id, hidden: true },
        { id: "name", name: shift.name },
        {
          id: "delete",
          delete: true,
          request: `http://localhost/api/shifts/delete.php?id=${shift.id}`,
        },
      ];

      while (this.$route.params.month == newDate.getMonth()) {
        let date_string = `${newDate.getFullYear()}-${this.normalizeNum(
          newDate.getMonth() + 1
        )}-${this.normalizeNum(newDate.getDate())}`;
        let flag = false;
        for (let date of shift.dates) {
          if (
            date.date ==
            `${newDate.getFullYear()}-${this.normalizeNum(
              newDate.getMonth() + 1
            )}-${this.normalizeNum(newDate.getDate())}`
          ) {
            elem.push({
              id: "date",
              name: [
                date.plan_hours ? date.plan_hours : 0,
                date.date_status == 1 ? true : false,
              ],
              date: true,
              request: `http://localhost/api/dates/add.php?date=${date_string}&shift_id=${shift.id}`,
            });
            flag = true;
            break;
          }
        }
        if (!flag) {
          elem.push({
            id: "date",
            name: [0, 0, false],
            date: true,
            request: `http://localhost/api/dates/add.php?date=${date_string}&shift_id=${shift.id}`,
          });
        }
        newDate = new Date(
          newDate.getFullYear(),
          newDate.getMonth(),
          newDate.getDate() + 1
        );
      }
      this.data.push(elem);
    },

    normalizeNum(num) {
      if (num > 0 && num < 10) {
        return "0" + num;
      }

      return num;
    },

    async addShift(department_id) {
      await axios
        .post("http://localhost/api/shifts/add.php", {
          name: this.name,
          department_id,
        })
        .then(() => {
          this.update();
          this.closeAdd();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },

    showAdd() {
      this.modalAdd = true;
    },

    closeAdd() {
      this.name = "";
      this.modalAdd = false;
    },

    update() {
      this.updated = true;
    },

    save(bool) {
      this.saved = bool;
    },
  },

  watch: {
    updated() {
      if (this.updated == true) {
        this.data = [];
        this.getShifts();
        this.updated = false;
      }
    },

    saved() {
      console.log(this.saved);
    },
  },
};
</script>

<style scoped>
.table-wrapper {
  max-height: calc(100vh - 300px);
}
</style>

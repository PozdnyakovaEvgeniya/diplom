<template>
  <div class="table-wrapper">
    <div class="table">
      <template v-for="(header, index) in headers">
        <div
          v-if="!header.hidden"
          :class="'cell header ' + header.id"
          :key="index"
        >
          {{ header.name }}
        </div>
      </template>

      <template v-for="elem in data" :key="elem[0].name">
        <template v-for="item in elem" :key="item.id">
          <div
            v-if="!item.hidden"
            :class="'cell ' + item.id"
            :id="selected ? 'elem' + elem[0].name : ''"
            @mouseenter="hover('elem' + elem[0].name)"
            @mouseleave="unhover('elem' + elem[0].name)"
            @click="$emit('rowClick', elem[0].name)"
          >
            <input
              :data-date="item.date"
              v-if="item.input && item.id == 'date'"
              type="text"
              :value="item.name"
            />
            <template v-else>{{ item.name }}</template>
          </div>
        </template>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    headers: Array,
    data: Array,
    selected: Boolean,
  },

  methods: {
    hover(id) {
      if (this.selected) {
        let cells = document.querySelectorAll("#" + id);
        for (let cell of cells) {
          cell.classList.add("hover");
        }
      }
    },

    unhover(id) {
      if (this.selected) {
        let cells = document.querySelectorAll("#" + id);
        for (let cell of cells) {
          cell.classList.remove("hover");
        }
      }
    },
  },
};
</script>

<style scoped>
.table-wrapper {
  width: 100%;
  overflow: auto;
  border: 1px solid var(--grey);
  border-radius: 5px;
  height: auto;
  max-height: calc(100vh - 181px);
}

.table {
  display: grid;
  width: 100%;
}

.header {
  grid-row: 1/3;
  font-weight: 600;
  position: sticky;
  top: 0;
  background: var(--white);
}

.cell {
  border-right: 1px solid var(--grey);
  border-bottom: 1px solid var(--grey);
  padding: 5px;
}

.hover {
  background-color: var(--grey);
  border-color: var(--white);
  cursor: pointer;
}
</style>

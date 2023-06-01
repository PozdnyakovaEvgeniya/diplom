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
            :class="'cell ' + item.id + (item.background ? ' background' : '')"
            :id="selected ? 'elem' + elem[0].name : ''"
            @mouseenter="hover('elem' + elem[0].name)"
            @mouseleave="unhover('elem' + elem[0].name)"
            @click="$emit('rowClick', elem[0].name)"
          >
            <Date
              v-if="item.date"
              :values="item.name"
              :request="item.request"
              :saved="saved"
              @save="$emit('save')"
            />
            <Delete
              v-else-if="item.delete"
              :request="item.request"
              @update="$emit('update')"
            ></Delete>
            <Hours v-else-if="item.hours" :values="item.name"></Hours>
            <template v-else>{{ item.name }}</template>
          </div>
        </template>
      </template>
    </div>
  </div>
</template>

<script>
import Delete from "@/components/Delete.vue";
import Date from "@/components/Date.vue";
import Hours from "@/components/Hours.vue";

export default {
  components: {
    Delete,
    Date,
    Hours,
  },

  props: {
    headers: Array,
    data: Array,
    selected: Boolean,
    saved: Boolean,
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
  width: auto;
  max-width: 100%;
}

.header {
  grid-row: 1/3;
  font-weight: 600;
  position: sticky;
  top: 0;
  background: var(--white);
}

.cell {
  border-left: 1px solid var(--grey);
  border-bottom: 1px solid var(--grey);
  padding: 5px;
}

.hover {
  background-color: var(--grey);
  border-color: var(--white);
  cursor: pointer;
}

.delete {
  border-left: none;
}

.background {
  background: var(--grey);
  border-left: 1px solid var(--white);
  border-bottom: 1px solid var(--white);
}
</style>

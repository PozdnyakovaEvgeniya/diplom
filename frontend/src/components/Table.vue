<template>
    <div class="table-wrapper">
        <div class="table">
            <div 
                v-for="(column, index) in columns"
                :class="'cell header ' + column.id"
                :key="index"
            >
                {{ column.name }}
            </div>
            <template v-for="row in rows" :key="row[0].name">
                <div 
                    v-for="(item, index) in row"
                    :class="'cell ' + item.id"
                    :key="index"
                    :id="'row' + row[0].name"
                    @mouseenter="hover('row' + row[0].name)"
                    @mouseleave="unhover('row' + row[0].name)"
                    @click="$emit('rowClick', row[0].name)"
                >
                    {{ item.name }}
                </div>
            </template>            
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            columns: Array,
            rows: Array,
            selected: Boolean,
        },

        methods: {
            hover(id) {
                if (this.selected) {
                    let cells = document.querySelectorAll('#' + id);
                    for (let cell of cells) {
                        cell.classList.add('hover');
                    }
                }                    
            },

            unhover(id) {
                if (this.selected) {
                    let cells = document.querySelectorAll('#' + id);
                    for (let cell of cells) {
                        cell.classList.remove('hover');
                    }
                }         
            }
        },
    }
</script>

<style scoped>
    .table-wrapper {
        width: 100%;
        overflow: auto;
        border: 1px solid var(--grey);
        border-radius: 5px;
    }

    .table {
        display: grid;
        width: 100%;
    }

    .header {
        grid-row: 1/3;
        font-weight: 600;
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
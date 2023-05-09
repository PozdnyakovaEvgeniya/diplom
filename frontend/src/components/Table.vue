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
            <template v-for="(row, index1) in rows" :key="index1">
                <div 
                    v-for="(item, index2) in row"
                    :class="'cell ' + item.id"
                    :key="index2"
                    @click="route"
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
            selected: String,
        },

        methods: {
            route() {

            }
        }
    }
</script>

<style scoped>
    .table-wrapper {
        width: 100%;
        overflow: auto;
    }

    .table {
        display: grid;
        border-left: 1px solid var(--grey);
        border-top: 1px solid var(--grey);
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
</style>
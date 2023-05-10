<template>
    <div class="employee_page">

    </div>
</template>

<script>
    import Header from '@/components/Header.vue';

    export default {
        components: {
            Header,
        },

        data() {
            return {
                
            }
        }, 

        mounted() {
            console.log(this.$route.params);
        }
    }
</script>

<style>

</style>
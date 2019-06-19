<template>
    <input type="checkbox" :id="series.id" :checked="series.selected" @click="click">
</template>

<script>
    export default {
        props: ['series'],

        methods: {
            click() {
                this.$emit('input', !this.series.selected);
            }
        }
    }
</script>
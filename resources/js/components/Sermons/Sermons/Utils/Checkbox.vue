<template>
    <input type="checkbox" :id="sermon.id" :checked="sermon.selected" @click="click">
</template>

<script>
    export default {
        props: ['sermon'],

        methods: {
            click() {
                this.$emit('input', !this.sermon.selected);
            }
        }
    }
</script>
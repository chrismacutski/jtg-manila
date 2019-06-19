<template>
    <input type="checkbox" :id="event.id" :checked="event.selected" @click="click">
</template>

<script>
    export default {
        props: ['event'],

        methods: {
            click() {
                this.$emit('input', !this.event.selected);
            }
        }
    }
</script>
<template>

    <div class="d-flex align-baseline">
        <div class="mr-2">
            <input type="checkbox" :id="user.id" :checked="user.selected" @click="click">
        </div>
        <div>
           <label class="mb-0" :for="user.id">
               {{ user.last_name }},
               {{ user.first_name }}
           </label>
            <div>
                <span class="mr-1 badge badge-secondary" v-for="role in user.roles.all()" v-text="role.name"></span>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['user'],

        methods: {
            click() {
                this.$emit('input', !this.user.selected);
            }
        }
    }
</script>
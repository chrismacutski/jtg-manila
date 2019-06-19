<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Users</div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item" v-for="user in users.sortBy('last_name').all()">
                            <user :user="user" v-model="user.selected"></user>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Roles</div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item" v-for="role in roles">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>{{ role.name }}</div>
                                <div>
                                    <button class="btn btn-sm btn-success" type="button" @click="assign(role)">Assign</button>
                                    <button class="btn btn-sm btn-danger" type="button" @click="remove(role)">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Log</div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item" v-for="log in logs.all()">
                            <div>
                                <small class="text-muted">{{ log.created_at }}</small>
                            </div>
                            <div>
                                <small>{{ log.description }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import User from './User'

    export default {
        components: { User },
        props: ['userList', 'roles', 'activities'],
        data() {
            return {
                users: collect([]),
                logs: collect([]),
            }
        },
        created() {
            _.forEach(this.userList, (user) => {
                user.selected = false;
                user.roles = collect(user.roles);
                this.users.push(user);
            });

            _.forEach(this.activities, (activity) => {
                this.logs.push(activity);
            });
        },
        methods: {
            assign(role) {
                this.users.each((user) => {
                    if (user.selected && !user.roles.contains('id', role.id)) {
                        axios.post(`/users/${user.id}/roles/${role.id}`)
                            .then(({data}) => {
                                this.logs.prepend(data.activity);
                                user.roles.push(role);
                            });
                    }
                });
            },
            remove(role) {
                this.users.each((user) => {
                    if (user.selected) {

                        let index = _.findIndex(user.roles.all(), ['id', role.id]);

                        if (index >= 0) {
                            axios.delete(`/users/${user.id}/roles/${role.id}`)
                                 .then(({data}) => {
                                     this.logs.prepend(data.activity);
                                     user.roles.splice(index, 1);
                                 });
                        }
                    }
                });
            }
        }
    }
</script>
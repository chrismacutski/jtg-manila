<template>
    <div>
        <div class="d-flex justify-content-between">
            <button type="button" @click="$emit('not-a-member')" class="text-white btn btn-link p-0">
                <u>Go back to fill up the form</u>
            </button>
            <button type="button" @click="show_registration_form = true" class="text-white btn btn-link p-0">
                <u>Click this to Register as a Member</u>
            </button>
        </div>

        <form @submit.prevent="onSubmit">
            <template v-if="!show_registration_form">
                <div class="form-group mb-4">
                    <div class="form-row">
                        <div class="col">
                            <input id="username"
                                   type="text"
                                   name="username"
                                   ref="username"
                                   placeholder="USERNAME*"
                                   v-model="form.username"
                                   :class="[errors.username ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                            <div :class="[errors.username ? 'invalid-feedback text-left' : '']">
                                <template v-for="error in errors.username">{{ error }}</template>
                            </div>
                        </div>
                        <div class="col">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   placeholder="PASSWORD"
                                   v-model="form.password"
                                   :class="[errors.password ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                            <div :class="[errors.password ? 'invalid-feedback text-left' : '']">
                                <template v-for="error in errors.password">{{ error }}</template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-end">
                        <button :disabled="disableLogInButton"
                                type="submit"
                                class="btn btn-primary py-3 px-5 loginClass mr-2"
                                v-html="loginButtonText"></button>
                    </div>
                </div>
            </template>
            <div class="form-group" v-if="show_registration_form">
                <member-register :show-registration="show_registration_form"
                                 :type="type"
                                 :model-id="modelId"
                                 @show-registration="showRegistration"></member-register>
            </div>
        </form>
    </div>
</template>

<style>
    .loginClass {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 18px;
        font-weight: 500;
    }
</style>

<script>
    export default {
        props : [
            'type' , 'modelId'
        ],

        data () {
            return {
                form: {
                    username : '',
                    password : '',
                    type: this.type,
                    model_id: this.modelId
                },

                errors : [],

                loginButtonText: 'Login',

                show_registration_form: false
            }
        },

        watch: {
            'form.username'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'username');
                }
            },

            'form.password'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'password');
                }
            }
        },

        computed: {
            disableLogInButton() {
                if (this.loginButtonText == 'Login') {
                    return false;
                }

                return true;
            },
        },

        methods: {
            onSubmit() {
                this.loginButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                axios.post(`/member/login`, this.form)
                    .then(({data}) => {
                        if (data.success == true) {
                            this.$emit('successful', data.attendee);
                            this.form.username = '';
                            this.form.password = '';

//                            if (data.type == 'event') {
//                                this.$noty.success("You are now part of " + data.data.name + ", See you there!", {
//                                    theme: 'metroui',
//                                    layout: 'topRight',
//                                })
//                            }
                        } else {
                            this.$noty.success("Something went wrong! Please try again or contact us", {
                                theme: 'metroui',
                                layout: 'topRight',
                            })
                        }

                        this.loginButtonText = 'Login';
                    }).catch(error => {
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }

                        if(error.response.data.message) {
                            this.form.username = '';
                            this.form.password = '';

                            this.$nextTick(() => this.$refs.username.focus())

                            this.$noty.error(error.response.data.message, {
                                theme: 'metroui',
                                layout: 'topRight',
                            })
                        }

                        this.loginButtonText = 'Login';
                    });
            },

            showRegistration(data) {
                this.show_registration_form = data;
            }
        }
    }
</script>
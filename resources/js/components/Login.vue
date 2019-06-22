<template>
    <div>
        <form @submit.prevent="onSubmit">
            <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">USERNAME</label>

                <div class="col-md-6">
                    <input id="username"
                           type="text"
                           name="username"
                           ref="username"
                           v-model="form.username"
                           :class="[errors.username ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                    <div :class="[errors.username ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.username">{{ error }}</template>
                    </div>

                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">PASSWORD</label>

                <div class="col-md-6">
                    <input id="password"
                           type="password"
                           name="password"
                           ref="password"
                           v-model="form.password"
                           :class="[errors.password ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                    <div :class="[errors.password ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.password">{{ error }}</template>
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
        data () {
            return {
                form: {
                    username : '',
                    password : '',
                    type: '',
                    model_id: ''
                },

                errors : [],

                loginButtonText: 'Login',
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
                            window.location.href = '/backend';
                        }
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
            }
        }
    }
</script>
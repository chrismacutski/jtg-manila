<template>
    <div class="mt-4">
        <div v-if="showRegistration">
            <form @submit.prevent="onSubmit">
                <h5 class="text-white d-flex justify-content-start">MEMBER ACCOUNT DETAILS</h5>

                <div class="form-group mb-4">
                    <div class="form-group">
                        <input id="first_name"
                               type="text"
                               name="first_name"
                               placeholder="FIRST NAME*"
                               v-model="form.first_name"
                               :class="[errors.first_name ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']"
                               required/>

                        <div :class="[errors.first_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.first_name">{{ error }}</template>
                        </div>
                    </div>

                    <div class="form-group">
                        <input id="middle_name"
                               type="text"
                               name="middle_name"
                               placeholder="MIDDLE NAME"
                               v-model="form.middle_name"
                               :class="[errors.middle_name ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']"/>

                        <div :class="[errors.middle_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.middle_name">{{ error }}</template>
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="last_name"
                               type="text"
                               name="last_name"
                               placeholder="LAST NAME*"
                               v-model="form.last_name"
                               :class="[errors.last_name ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']"
                               required/>

                        <div :class="[errors.last_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.last_name">{{ error }}</template>
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="username"
                               type="text"
                               name="username"
                               placeholder="USERNAME*"
                               v-model="form.username"
                               :class="[errors.username ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']"
                               required/>

                        <div :class="[errors.username ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.username">{{ error }}</template>
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="password"
                               type="password"
                               :class="[errors.password ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']"
                               placeholder="PASSWORD*"
                               v-model="form.password"
                               name="password" required>

                        <div :class="[errors.password ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.password">{{ error }}</template>
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="password-confirm"
                               type="password"
                               :class="[errors.password_confirmation ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']"
                               placeholder="CONFIRM PASSWORD*"
                               v-model="form.password_confirmation"
                               name="password_confirmation" required>

                        <div :class="[errors.password_confirmation ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.password_confirmation">{{ error }}</template>
                        </div>
                    </div>
                </div>

                <h5 class="text-white d-flex justify-content-start">CONTACT INFO</h5>


                <div class="form-group">
                    <input id="phone_number"
                           type="number"
                           name="phone_number"
                           placeholder="CONTACT NUMBER"
                           v-model="form.phone_number"
                           :class="[errors.phone_number ? 'form-control is-invalid' : 'form-control']" />

                    <div :class="[errors.phone_number ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.phone_number">{{ error }}</template>
                    </div>
                </div>

                <div class="form-group">
                    <input id="email_address"
                           type="email"
                           name="email_address"
                           placeholder="EMAIL ADDRESS"
                           v-model="form.email_address"
                           :class="[errors.email_address ? 'form-control is-invalid' : 'form-control']" />

                    <div :class="[errors.email_address ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.email_address">{{ error }}</template>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-end">
                        <button :disabled="disableRegisterButton"
                                type="submit"
                                class="btn btn-primary py-3 px-5 registerClass mr-2"
                                v-html="registerButtonText"></button>

                        <button @click="$emit('show-registration', false)"
                                type="button"
                                class="btn btn-primary py-3 px-5 registerClass">CANCEL</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<style>
    .registerClass {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 18px;
        font-weight: 500;
    }

    .sModal {
        z-index: 99999999999 !important;
    }
</style>

<script>

    export default {
        props: ['showRegistration', 'type', 'modelId'],

        data () {
            return {
                form: {
                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    username : '',
                    password : '',
                    password_confirmation : '',
                    email_address : '',
                    phone_number: '',
                    type: this.type,
                    model_id: this.modelId
                },

                errors : [],

                registerButtonText: 'REGISTER'
            }
        },

        watch: {
            'form.first_name'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'first_name');
                }
            },
            'form.last_name'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'last_name');
                }
            },
            'form.username'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'username');
                }
            },

            'form.password'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'password');
                }
            },

            'form.password_confirmation'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'password_confirmation');
                }
            }
        },

        computed: {
            disableRegisterButton() {
                if (this.registerButtonText == 'REGISTER') {
                    return false;
                }

                return true;
            },
        },

        methods: {
            onSubmit() {
                this.registerButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                axios.post(`/member/register`, this.form)
                    .then(({data}) => {
                        console.log(data);
                        this.$noty.success("Successfully registered, you are now part of the JTG Manila Family", {
                            theme: 'metroui',
                            layout: 'topRight',
                        })
//                        window.location.href = '/members/' + data.id;
                    }).catch(error => {
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }

                        if (error.response.data.message) {
                            if (error.response.data.message != 'The given data was invalid.') {
                                this.$noty.error("Something went wrong, please try again or contact us", {
                                    theme: 'metroui',
                                    layout: 'topRight',
                                })
                            } else {
                                this.$noty.error("The given data was invalid, please update the form.", {
                                    theme: 'metroui',
                                    layout: 'topRight',
                                })
                            }
                        }

                        this.registerButtonText = 'REGISTER';
                    });
            },

            showModal() {
                this.$refs.modal.open();
            },

            closeModal() {
                this.clearForm();
            },

            clearForm() {
                this.errors = [];
            }
        }
    }
</script>
<template>
    <div>
        <h3 class="jtg-animate text-center">REGISTER</h3>

        <p class="font-weight-bold text-center" v-if="hideMemberLogin">
            <span class="text-danger">Already a member? If so, </span>
            <button type="button" @click="hideMemberLogin = false" class="text-white btn btn-link p-0"><u>click this and login</u></button>
            <span class="text-danger">to save time in filling out this form!</span>
        </p>
        <member-login v-if="!hideMemberLogin"
                      :type="'event'"
                      :model-id="jtgEvent.id"
                      @not-a-member="hideMemberLogin = true"
                      @successful="hideMemberLogin = true"></member-login>
        <form @submit.prevent="onSubmit" v-if="hideMemberLogin">
            <div class="form-group mb-4">
                <h5 class="text-white d-flex justify-content-start">WHAT'S YOUR NAME?</h5>
                <div class="form-row">
                    <div class="col">
                        <input id="first_name"
                               type="text"
                               name="first_name"
                               placeholder="FIRST NAME*"
                               v-model="form.first_name"
                               :class="[errors.first_name ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                        <div :class="[errors.first_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.first_name">{{ error }}</template>
                        </div>
                    </div>
                    <div class="col">
                        <input id="last_name"
                               type="text"
                               name="last_name"
                               placeholder="LAST NAME*"
                               v-model="form.last_name"
                               :class="[errors.last_name ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                        <div :class="[errors.last_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.last_name">{{ error }}</template>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="text-white d-flex justify-content-start">HOW CAN WE CONTACT YOU?</h5>

            <div class="form-group">
                <input id="phone_number"
                       type="number"
                       name="phone_number"
                       placeholder="CONTACT NUMBER*"
                       v-model="form.phone_number"
                       :class="[errors.phone_number ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                <div :class="[errors.phone_number ? 'invalid-feedback text-left' : '']">
                    <template v-for="error in errors.phone_number">{{ error }}</template>
                </div>
            </div>

            <div class="form-group mb-4">
                <input id="email_address"
                       type="email"
                       name="email_address"
                       placeholder="EMAIL ADDRESS"
                       v-model="form.email_address"
                       :class="[errors.email_address ? 'form-control input-lg rounded-0 is-invalid' : 'form-control input-lg rounded-0']" />

                <div :class="[errors.email_address ? 'invalid-feedback text-left' : '']">
                    <template v-for="error in errors.email_address">{{ error }}</template>
                </div>
            </div>


            <div class="form-group">
                <h5 class="text-white d-flex justify-content-start">HAVE ANY QUESTIONS? LET US KNOW!</h5>
                <textarea v-model="form.message"
                          cols="30"
                          rows="8"
                          :class="[errors.message ? 'form-control rounded-0 is-invalid' : 'form-control rounded-0']">
                </textarea>

                <div :class="[errors.message ? 'invalid-feedback text-left' : '']">
                    <template v-for="error in errors.message">{{ error }}</template>
                </div>
            </div>

            <div class="form-group">
                <div class="d-flex justify-content-end">
                    <button :disabled="disableSubmitButton"
                            type="submit"
                            class="btn btn-primary py-3 px-5 submitClass"
                            v-html="submitButtonText"></button>
                </div>
            </div>
        </form>
    </div>
</template>

<style>
    .submitClass {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 18px;
        font-weight: 500;
    }
</style>

<script>
    import MemberLogin from '../Member/Login.vue';
    export default {
        props: [
            'jtgEvent'
        ],

        components : {
            MemberLogin
        },

        data () {
            return {
                form: {
                    first_name : '',
                    last_name : '',
                    email_address: '',
                    phone_number: '',
                    type: '',
                    message: ''
                },

                errors : [],

                submitButtonText: 'SUBMIT',

                hideMemberLogin: true
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

            'form.email_address'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'email_address');
                }
            },

            'form.phone_number'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'phone_number');
                }
            },

            'form.type'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'type');
                }
            }
        },

        computed: {
            disableSubmitButton() {
                if (this.submitButtonText == 'SUBMIT') {
                    return false;
                }

                return true;
            },
        },

        methods: {
            onSubmit() {
                this.submitButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                axios.post(`/events/${this.jtgEvent.hash_id}/guest-sign-up`, this.form)
                    .then(({data}) => {
                        this.form.first_name = '';
                        this.form.last_name = '';
                        this.form.email_address = '';
                        this.form.phone_number = '';
                        this.form.type = '';
                        this.form.message = '';

                        this.$noty.success("You are now part of " + data.name + ", See you there!", {
                            theme: 'metroui',
                            layout: 'topRight',
                        })
                    }).catch(error => {
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }

                        if(error.response.data.message) {
                            this.form.first_name = '';
                            this.form.last_name = '';
                            this.form.email_address = '';
                            this.form.phone_number = '';
                            this.form.type = '';
                            this.form.message = '';

                            this.$nextTick(() => this.$refs.username.focus())

                            this.$noty.error(error.response.data.message, {
                                theme: 'metroui',
                                layout: 'topRight',
                            })
                        }


                        this.submitButtonText = 'SUBMIT';
                    });
            }
        }
    }
</script>
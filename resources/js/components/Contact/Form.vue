<template>
    <div>
        <form @submit.prevent="onSubmit">
            <div class="form-group">
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

            <div class="form-group">
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
                <h6 class="text-white">TYPE OF CONTACT</h6>
                <div class="form-check">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio1" value="General" v-model="form.type" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label text-white" for="customRadio1">General</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="customRadio2" value="Prayer Request" v-model="form.type" name="customRadio" class="custom-control-input">
                        <label class="custom-control-label text-white" for="customRadio2">Prayer Request</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <textarea placeholder="MESSAGE*"
                          v-model="form.message"
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

    export default {
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
                this.submitButtonText = 'Submitting ...';

                axios.post(`/customer`, this.form)
                    .then(({data}) => {
                        this.$emit('created-customer');
                    }).catch(error => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }

                    this.submitButtonText = 'SUBMIT';
                });
            }
        }
    }
</script>
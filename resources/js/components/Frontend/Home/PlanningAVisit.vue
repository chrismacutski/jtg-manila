<template>
    <div>
        <div class="jtg-planning-a-visit py-2" v-lazy:background-image="image">
            <div class="overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 jtg-visit text-center p-5">
                        <h3 class="jtg-animate mb-2">You are always welcome at JTG Manila Church!</h3>
                        <h6 class="mt-2 font-weight-bold jtg-animate">Plan your visit and let us know that you're coming</h6>

                        <p>
                            <button @click="showModal" class="btn btn-transparent py-3 px-4 jtg-animate">LET US KNOW YOU'RE COMING <i class="icon-chevron-right"></i></button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <sweet-modal ref="modal" modal-theme="dark" overlay-theme="dark" @close="closeModal" class="sModal">
            <div class="card bg-transparent mt-4 mb-4">
                <div class="card-body">
                    <form @submit.prevent="onSubmit">
                        <div class="form-group">
                            <h5 class="text-white d-flex justify-content-start">WHAT'S YOUR NAME?</h5>
                            <div class="form-row">
                                <div class="col">
                                    <input id="first_name"
                                           type="text"
                                           name="first_name"
                                           placeholder="FIRST NAME*"
                                           v-model="form.first_name"
                                           :class="[errors.first_name ? 'form-control is-invalid' : 'form-control']" />

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
                                           :class="[errors.last_name ? 'form-control is-invalid' : 'form-control']" />

                                    <div :class="[errors.last_name ? 'invalid-feedback text-left' : '']">
                                        <template v-for="error in errors.last_name">{{ error }}</template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5 class="text-white d-flex justify-content-start">HOW CAN WE CONTACT YOU?</h5>
                            <div class="form-row">
                                <div class="col">
                                    <input id="phone_number"
                                           type="number"
                                           name="phone_number"
                                           placeholder="CONTACT NUMBER*"
                                           v-model="form.phone_number"
                                           :class="[errors.phone_number ? 'form-control is-invalid' : 'form-control']" />

                                    <div :class="[errors.phone_number ? 'invalid-feedback text-left' : '']">
                                        <template v-for="error in errors.phone_number">{{ error }}</template>
                                    </div>
                                </div>
                                <div class="col">
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
                            </div>
                        </div>

                        <div class="form-group">
                            <h5 class="text-white d-flex justify-content-start">PREFERRED DATE OF VISIT</h5>
                            <input type="date"
                                   v-model="form.visiting_at"
                                   :class="[errors.visiting_at ? 'form-control is-invalid' : 'form-control']" />
                            <!--<flat-pickr v-model="form.visiting_at"-->
                                        <!--:config="config"-->
                                        <!--class="form-control"></flat-pickr>-->

                            <div :class="[errors.visiting_at ? 'invalid-feedback text-left' : '']">
                                <template v-for="error in errors.visiting_at">{{ error }}</template>
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
            </div>
        </sweet-modal>
    </div>
</template>

<style>
    .submitClass {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 18px;
        font-weight: 500;
    }

    .sModal {
        z-index: 16 !important;
    }

    .flatpickr-calendar {
        z-index: 20 !important;
    }
</style>

<script>
    export default {
        props: ['image'],

        data() {
            return {
                modal_title: '',

                windowWidth: '',
                windowHeight: '',

                form: {
                    first_name : '',
                    last_name : '',
                    email_address: '',
                    phone_number: '',
                    type: '',
                    visiting_at: ''
                },

                errors : [],

                submitButtonText: 'SUBMIT',

                config: {
                    wrap: true, // set wrap to true only when using 'input-group'
                    altFormat: 'M j, Y G:i K',
                    altInput: true,
                    dateFormat: 'Y-m-d H:i:s',
                    enableTime: true
                }
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

        mounted() {
            this.$nextTick(function() {
                window.addEventListener('resize', this.getWindowWidth);
                window.addEventListener('resize', this.getWindowHeight);

                //Init
                this.getWindowWidth()
                this.getWindowHeight()
            })
        },

        methods: {
            showModal() {
                this.modal_title = `Heartbeat`;
                this.$refs.modal.open();
            },

            closeModal() {
                this.clearForm();
            },

            clearForm() {
                this.modal_title = '';

                this.errors = [];
            },

            getWindowWidth(event) {
                this.windowWidth = document.documentElement.clientWidth - 100;
            },

            getWindowHeight(event) {
                this.windowHeight = document.documentElement.clientHeight - 200;
            },

            onSubmit() {
                this.submitButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                axios.post(`/visitors`, this.form)
                    .then(({data}) => {
                        let visiting_at = moment(data.visiting_at).format('LL');

                        this.$refs.modal.close();

                        this.$noty.success("Thank you, we expect to see you on " + visiting_at, {
                            theme: 'metroui',
                            layout: 'topRight',
                        })

                        this.submitButtonText = 'SUBMIT';

                        this.form.first_name = '';
                        this.form.last_name = '';
                        this.form.email_address = '';
                        this.form.phone_number = '';
                        this.form.type = '';
                        this.form.visiting_at = '';
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
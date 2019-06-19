<template>
    <div>
        <div class="sc-launcher" :class="{opened: show_chat, closed: !show_chat}" @click.prevent="onClose" style="background: #808080">
            <img class="sc-open-icon" src="../../../assets/close-icon.png" />
            <img class="sc-closed-icon" src="../../../assets/logo-no-bg.svg" />
        </div>
        <div class="sc-chat-window" :class="{opened: show_chat, closed: !show_chat}">
            <div class="sc-header" style="background: #212529; color: #ffffff">
                <div class="sc-header--title"> JTG MANILA CHURCH </div>
                <div class="sc-header--close-button" @click="onClose">
                    <img src="../../../assets/close-icon.png" alt="" />
                </div>
            </div>
            <div class="card-body overflow-auto d-flex flex-column">
                <form @submit.prevent="onSubmit">
                    <h5 class="d-flex justify-content-start">WHAT'S YOUR NAME?</h5>

                    <div class="form-group">
                        <input id="first_name"
                               type="text"
                               name="first_name"
                               placeholder="First Name"
                               v-model="form.first_name"
                               :class="[errors.first_name ? 'form-control is-invalid' : 'form-control']" />

                        <div :class="[errors.first_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.first_name">{{ error }}</template>
                        </div>
                    </div>

                    <div class="form-group">
                        <input id="middle_name"
                               type="text"
                               name="middle_name"
                               placeholder="Middle Name"
                               v-model="form.middle_name"
                               :class="[errors.middle_name ? 'form-control is-invalid' : 'form-control']" />

                        <div :class="[errors.middle_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.middle_name">{{ error }}</template>
                        </div>
                    </div>

                    <div class="form-group">
                        <input id="last_name"
                               type="text"
                               name="last_name"
                               placeholder="Last Name"
                               v-model="form.last_name"
                               :class="[errors.last_name ? 'form-control is-invalid' : 'form-control']" />

                        <div :class="[errors.last_name ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.last_name">{{ error }}</template>
                        </div>
                    </div>
                    <h5 class="mt-4 d-flex justify-content-start">HOW CAN WE CONTACT YOU?</h5>

                    <div class="form-group">
                        <input id="email_address"
                               type="email"
                               name="email_address"
                               placeholder="Email Address"
                               v-model="form.email_address"
                               :class="[errors.email_address ? 'form-control is-invalid' : 'form-control']" />

                        <div :class="[errors.email_address ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.email_address">{{ error }}</template>
                        </div>
                    </div>

                    <div class="form-group">
                        <input id="phone_number"
                               type="number"
                               name="phone_number"
                               placeholder="Contact Number"
                               v-model="form.phone_number"
                               :class="[errors.phone_number ? 'form-control is-invalid' : 'form-control']" />

                        <div :class="[errors.phone_number ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.phone_number">{{ error }}</template>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="d-flex justify-content-end">
                            <button :disabled="disableSubmitButton" type="submit" class="btn btn-primary" v-html="submitButtonText"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<style>
    .btn-primary {
        color: #fff;
        background-color: #212529;
        border-color: #212529;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #212529;
        border-color: #212529;
    }

    .btn-primary:focus,
    .btn-primary.focus {
        box-shadow: #212529;
    }

    .btn-primary.disabled,
    .btn-primary:disabled {
        color: #fff;
        background-color: #212529;
        border-color: #212529;
    }

    .btn-primary:not(:disabled):not(.disabled):active,
    .btn-primary:not(:disabled):not(.disabled).active,
    .show > .btn-primary.dropdown-toggle {
        color: #fff;
        background-color: #212529;
        border-color: #1f6fb2;
    }

    .sc-launcher {
        z-index: 99999999999 !important;
        width: 60px;
        height: 60px;
        background-position: center;
        background-repeat: no-repeat;
        position: fixed;
        right: 25px;
        bottom: 25px;
        border-radius: 50%;
        box-shadow: none;
        transition: box-shadow 0.2s ease-in-out;
        cursor: pointer;
    }

    .sc-launcher:before {
        content: '';
        position: relative;
        display: block;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        transition: box-shadow 0.2s ease-in-out;
    }

    .sc-launcher .sc-open-icon,
    .sc-launcher .sc-closed-icon {
        width: 60px;
        height: 60px;
        position: fixed;
        right: 25px;
        bottom: 25px;
        transition: opacity 100ms ease-in-out, transform 100ms ease-in-out;
    }

    .sc-launcher .sc-closed-icon {
        transition: opacity 100ms ease-in-out, transform 100ms ease-in-out;
        width: 60px;
        height: 60px;
    }

    .sc-launcher .sc-open-icon {
        padding: 20px;
        box-sizing: border-box;
        opacity: 0;
    }

    .sc-launcher.opened .sc-open-icon {
        transform: rotate(-90deg);
        opacity: 1;
    }

    .sc-launcher.opened .sc-closed-icon {
        transform: rotate(-90deg);
        opacity: 0;
    }

    .sc-launcher.opened:before {
        box-shadow: 0px 0px 400px 250px rgba(148, 149, 150, 0.2);
    }

    .sc-launcher:hover {
        box-shadow: 0 0px 27px 1.5px rgba(0,0,0,0.2);
    }

    .sc-new-messsages-count {
        position: absolute;
        top: -3px;
        left: 41px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        background: #ff4646;
        color: white;
        text-align: center;
        margin: auto;
        font-size: 12px;
        font-weight: 500;
    }

    .sc-chat-window {
        z-index: 99999999999 !important;
        width: 370px;
        height: calc(100% - 120px);
        max-height: 590px;
        position: fixed;
        right: 25px;
        bottom: 100px;
        box-sizing: border-box;
        box-shadow: 0px 7px 40px 2px rgba(148, 149, 150, 0.1);
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: 0.3s ease-in-out;
        border-radius: 10px;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .sc-chat-window.closed {
        opacity: 0;
        visibility: hidden;
        bottom: 90px;
    }

    .sc-message--me {
        text-align: right;
    }
    .sc-message--them {
        text-align: left;
    }

    @media (max-width: 450px) {
        .sc-chat-window {
            width: 100%;
            height: 100%;
            max-height: 100%;
            right: 0px;
            bottom: 0px;
            border-radius: 0px;
        }
        .sc-chat-window {
            transition: 0.1s ease-in-out;
        }
        .sc-chat-window.closed {
            bottom: 0px;
        }
    }


    .sc-header {
        min-height: 75px;
        border-top-left-radius: 9px;
        border-top-right-radius: 9px;
        padding: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
        position: relative;
        box-sizing: border-box;
        display: flex;
    }

    .sc-header--img {
        border-radius: 50%;
        align-self: center;
        padding: 10px;
    }

    .sc-header--title {
        align-self: center;
        padding: 10px;
        flex: 1;
        user-select: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .sc-header--title:hover {
        box-shadow: 0px 2px 5px rgba(0.2, 0.2, 0.5, .1);
    }

    .sc-header--close-button {
        width: 40px;
        align-self: center;
        height: 40px;
        margin-right: 10px;
        box-sizing: border-box;
        cursor: pointer;
        border-radius: 5px;
    }

    .sc-header--close-button:hover {
        box-shadow: 0px 2px 5px rgba(0.2, 0.2, 0.5, .1);
    }

    .sc-header--close-button img {
        width: 100%;
        height: 100%;
        padding: 13px;
        box-sizing: border-box;
    }

    @media (max-width: 450px) {
        .sc-header {
            border-radius: 0px;
        }
    }
</style>

<script>

    export default {
        props: ['sessionId'],

        data () {
            return {
                show_chat: false,

                form: {
                    first_name : '',
                    middle_name : '',
                    last_name : '',
                    email_address: '',
                    phone_number: ''
                },

                errors : [],

                submitButtonText: 'SUBMIT',
            }
        },

        mounted() {
            if (window.localStorage.getItem('showChat')) {
                this.show_chat = true;
            } else {
                this.show_chat = false;
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

                axios.post(`/${this.sessionId}/chatter`, this.form)
                    .then(({data}) => {
                        this.$emit('created-chatter');
                    }).catch(error => {
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }

                        this.submitButtonText = 'SUBMIT';
                    });
            },

            onClose() {
                this.show_chat = !this.show_chat;

                if (this.show_chat == true) {
                    window.localStorage.setItem('showChat', '1');
                } else {
                    window.localStorage.setItem('showChat', '');
                }
            }
        }
    }
</script>
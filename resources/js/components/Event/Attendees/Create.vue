<template>
    <div class="container">
        <form @submit.prevent="onCreate">
            <div class="row">
                <div class="col-md-8 offset-2">
                    <div class="card">
                        <div class="card-header bg-darker text-white">
                            <h6 class="text-center text-white">NEW EVENT ATTENDEE</h6>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label>Member Name</label>
                                <select v-model="form.member_id"
                                        :class="[errors.member_id ? 'form-control is-invalid' : 'form-control']">
                                    <option value="">-- Choose One --</option>
                                    <option v-for="(val, key) in members" :value="val.id">{{ val.name }}</option>
                                </select>

                                <div :class="[errors.member_id ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.member_id">{{ error }}</template>
                                </div>
                            </div>

                            <template v-if="shouldHideDetails == false">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col">
                                            <label>First Name</label>
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
                                            <label>Last Name</label>
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
                                    <label>Phone Number</label>
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

                                <div class="form-group mb-4">
                                    <label>Email Address</label>
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
                            </template>

                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button :disabled="disableCreateButton"
                                            type="submit"
                                            class="btn btn-primary"
                                            v-html="createButtonText"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['event'],

        data () {
            return {
                form: {
                    member_id: '',
                    first_name: '',
                    last_name: '',
                    phone_number: '',
                    email_address: ''
                },

                members: collect([]),

                errors : [],

                createButtonText: 'Create',

                shouldHideDetails: false
            }
        },

        mounted() {
            this.getMembers();
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

            'form.phone_number'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'phone_number');
                }
            },

            'form.email_address'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'address');
                }
            },

            'form.member_id'(newValue) {
                if (newValue) {
                    let member = this.members.where('id',newValue).first();

                    let phone_numbers = collect(member.phone_numbers);
                    let email_addresses = collect(member.email_addresses);

                    this.form.first_name = member.first_name;
                    this.form.last_name = member.last_name;
                    let phone_number = phone_numbers.count() > 0 ? phone_numbers.first().phone_number: '';
                    this.form.phone_number = phone_number;
                    let email_address = email_addresses.count() > 0 ? email_addresses.first().email_address: '';
                    this.form.email_address = email_address;

                    this.shouldHideDetails = true;
                } else {
                    this.shouldHideDetails = false;

                    this.form.first_name = '';
                    this.form.last_name = '';
                    this.form.email_address = '';
                    this.form.phone_number = '';
                }
            }
        },

        computed: {
            disableCreateButton() {
                if (this.createButtonText == 'Create') {
                    return false;
                }

                return true;
            },
        },

        methods: {
            onCreate() {
                this.createButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                axios.post(`/admin/events/${this.event.hash_id}/attendees`, this.form)
                    .then(({data}) => {
                        this.$noty.success("Successfully added attendee to Event " + this.event.name, {
                            theme: 'metroui',
                            layout: 'topRight',
                        })
                        window.location.href = '/admin/events/' + this.event.hash_id;
                    }).catch(error => {
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }

                        if (error.response.data.message) {
                            this.$noty.error(error.response.data.message, {
                                theme: 'metroui',
                                layout: 'topRight',
                            })
                        }

                        this.createButtonText = 'Create';
                    });
            },

            getMembers() {
                axios.get('/admin/get-members', {})
                    .then(({data}) => {
                        this.members = collect(data);
                    });
            }
        }
    }
</script>
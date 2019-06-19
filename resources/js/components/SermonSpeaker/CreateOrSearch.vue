<template>
    <div>
        <div class="form-group">
            <label>SPEAKER</label>

            <div class="input-group mb-3">
                <select v-model="speaker_id"
                        :class="[errors.middle_name ? 'form-control is-invalid' : 'form-control']">
                    <option value="">-- Choose One --</option>
                    <option :value="id" v-for="(name, id) in speakers">{{ name }}</option>
                </select>

                <div class="input-group-append">
                    <button @click="showModal" type="button" class="btn btn-primary ml-1"><i class="fa fa-plus-circle fa-lg"></i></button>
                </div>
            </div>

            <div :class="[errors.speaker_id ? 'invalid-feedback text-left' : '']">
                <template v-for="error in errors.speaker_id">{{ error }} <br></template>
            </div>
        </div>

        <sweet-modal ref="modal" modal-theme="dark" overlay-theme="dark" class="sModalHistory">
            <form @submit.prevent="onCreate">
                <div class="form-group">
                    <input id="first_name"
                           type="text"
                           name="first_name"
                           placeholder="FIRST NAME"
                           v-model="form.first_name"
                           :class="[errors.first_name ? 'form-control is-invalid' : 'form-control']" />

                    <div :class="[errors.first_name ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.first_name">{{ error }} <br></template>
                    </div>
                </div>

                <div class="form-group">
                    <input id="middle_name"
                           type="text"
                           name="middle_name"
                           placeholder="MIDDLE NAME"
                           v-model="form.middle_name"
                           :class="[errors.middle_name ? 'form-control is-invalid' : 'form-control']" />

                    <div :class="[errors.middle_name ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.middle_name">{{ error }} <br></template>
                    </div>
                </div>

                <div class="form-group">
                    <input id="last_name"
                           type="text"
                           name="last_name"
                           placeholder="LAST NAME"
                           v-model="form.last_name"
                           :class="[errors.last_name ? 'form-control is-invalid' : 'form-control']" />

                    <div :class="[errors.last_name ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.last_name">{{ error }} <br></template>
                    </div>
                </div>

                <div class="form-group">
                    <label class="d-flex justify-content-start">IS GUEST</label>
                    <select v-model="form.is_guest"
                            :class="[errors.is_guest ? 'form-control is-invalid' : 'form-control']">
                        <option value="true">Yes</option>
                        <option value="false">No</option>
                    </select>

                    <div :class="[errors.is_guest ? 'invalid-feedback text-left' : '']">
                        <template v-for="error in errors.is_guest">{{ error }} <br></template>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-end">
                        <button :disabled="disableCreateButton" type="submit" class="btn btn-primary" v-html="createButtonText"></button>
                    </div>
                </div>
            </form>
        </sweet-modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                showCreateForm: false,

                createButtonText: 'Create',

                speakers: null,

                speaker_id: '',

                form: {
                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    is_guest: false
                },

                errors: []
            }
        },


        mounted() {
            this.getSpeakers();
        },


        computed: {
            disableCreateButton() {
                if (this.createButtonText == 'Create') {
                    return false;
                }

                return true;
            },
        },

        watch: {
            'speaker_id'(newValue) {
                if (newValue) {
                    this.$emit('speaker-selected', newValue);
                }
            }
        },

        methods: {
            getSpeakers() {
                axios.get(`/admin/sermon-speakers/list`, {})
                    .then(({data}) => {
//                        this.speakers.push(data);
                        this.speakers = data;
                    })
                    .catch(error => {
                    });
            },

            onCreate() {
                this.createButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                axios.post(`/admin/sermon-speakers`, this.form)
                    .then(({data}) => {
                        let speaker_id = data.id;
                        this.speaker_id = speaker_id;

                        this.speakers[speaker_id] = data.fullname;
                        this.$emit('speaker-created', speaker_id);
                        this.$refs.modal.close();
                        this.createButtonText = 'Create';
//                        window.location.href = '/admin/series';
                    }).catch(error => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }

                    this.createButtonText = 'Create';
                });
            },

            showModal() {
                this.$refs.modal.open();
            }
        }
    }
</script>
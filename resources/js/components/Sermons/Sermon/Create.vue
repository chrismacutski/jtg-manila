<template>
    <div class="container">
        <form @submit.prevent="onCreate">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-darker text-white">
                            <h6 class="text-center text-white">NEW SERMON</h6>
                        </div>
                        <div class="card-body">
                            <create-or-search-speaker @speaker-created="setSpeaker"
                                                      @speaker-selected="setSpeaker"></create-or-search-speaker>
                            <div class="form-group">
                                <label>NAME</label>
                                <input id="name"
                                       type="text"
                                       name="name"
                                       v-model="form.name"
                                       :class="[errors.name ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.name ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.name">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>DESCRIPTION</label>
                                <textarea placeholder="Type in the short description of the sermon"
                                          v-model="form.description"
                                          cols="30"
                                          rows="3"
                                          :class="[errors.name ? 'form-control is-invalid' : 'form-control']"></textarea>

                                <div :class="[errors.description ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.description">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>CONTENT</label>
                                <textarea placeholder="Type in the content of the sermon"
                                          v-model="form.content"
                                          cols="30"
                                          rows="6"
                                          :class="[errors.content ? 'form-control is-invalid' : 'form-control']"></textarea>

                                <div :class="[errors.content ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.content">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>SERIES IMAGE</label>
                                <input type="file"
                                       ref="image_src"
                                       name="image_src"
                                       multiple
                                       :class="[errors.image_src ? 'form-control is-invalid' : 'form-control']">

                                <div :class="[errors.image_src ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.image_src">{{ error }}</template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>YOUTUBE URL</label>
                                <input id="video_src"
                                       type="text"
                                       name="name"
                                       v-model="form.video_src"
                                       :class="[errors.video_src ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.video_src ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.video_src">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>FILE URL</label>
                                <input id="file_src"
                                       type="text"
                                       name="name"
                                       v-model="form.file_src"
                                       :class="[errors.file_src ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.file_src ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.file_src">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="d-flex justify-content-start">WILL START AT</label>
                                <flat-pickr v-model="form.happened_at"
                                            :config="dateConfig"
                                            :class="[errors.happened_at ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                <div :class="[errors.happened_at ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.happened_at">{{ error }}</template>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button :disabled="disableCreateButton" type="submit" class="btn btn-primary" v-html="createButtonText"></button>
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
    import CreateOrSearchSpeaker from '../../../components/SermonSpeaker/CreateOrSearch.vue';

    export default {
        components: {CreateOrSearchSpeaker},

        props: ['series'],

        data () {
            return {
                form: {
                    sermon_speaker_id : '',
                    name: '',
                    description : '',
                    content: '',
                    image_src: '',
                    image_thumbnail_src: '',
                    video_src: '',
                    file_src: '',
                    happened_at: ''
                },

                errors : [],

                createButtonText: 'Create',

                dateConfig: {
                    wrap: true, // set wrap to true only when using 'input-group'
                    altFormat: 'M j, Y',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    enableTime: false
                }
            }
        },

        watch: {
            'form.name'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'name');
                }
            },

            'form.address'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'address');
                }
            },

            'form.image_src'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'image_src');
                }
            },

            'form.image_thumbnail_src'(newValue) {
                if (newValue != '') {
                    this.errors = _.omit(this.errors, 'image_thumbnail_src');
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

                let params = new FormData();
                if (!_.isUndefined(this.$refs.image_src)) {
                    params.append('image_src', this.$refs.image_src.files[0]);
                }

                if (!_.isUndefined(this.$refs.image_thumbnail_src)) {
                    params.append('image_thumbnail_src', this.$refs.image_thumbnail_src.files[0]);
                }
                _.forEach(this.form, (item, index) => {
                    params.append(index, item);
                });


                axios.post(`/admin/series/${this.series.hash_id}/sermons`, params)
                    .then(({data}) => {
//                        window.location.href = '/admin/series/' +  data.id + '/sermons/create';
                    }).catch(error => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }

                    this.createButtonText = 'Create';
                });
            },

            setSpeaker(data) {
                this.form.sermon_speaker_id = data;
            }
        }
    }
</script>
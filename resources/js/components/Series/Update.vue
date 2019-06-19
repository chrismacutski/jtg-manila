<template>
    <div class="container">
        <form @submit.prevent="onUpdate">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header bg-darker text-white">
                        <h6 class="text-center text-white">UPDATE EVENT</h6>
                    </div>
                    <div class="card">
                        <div class="card-body">
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
                                <textarea placeholder="Type in the short description of the event"
                                          v-model="form.description"
                                          cols="30"
                                          rows="3"
                                          :class="[errors.name ? 'form-control is-invalid' : 'form-control']"></textarea>

                                <div :class="[errors.description ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.description">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>ADDRESS</label>
                                <input id="address"
                                       type="text"
                                       name="address"
                                       v-model="form.address"
                                       :class="[errors.address ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.address ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.address">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="d-flex justify-content-start">WILL START AT</label>
                                <flat-pickr v-model="form.starting_at"
                                            :config="dateConfig"
                                            :class="[errors.starting_at ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                <div :class="[errors.starting_at ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.starting_at">{{ error }}</template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="d-flex justify-content-start">WILL END AT</label>
                                <flat-pickr v-model="form.ending_at"
                                            :config="dateConfig"
                                            :class="[errors.ending_at ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                <div :class="[errors.ending_at ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.ending_at">{{ error }}</template>
                                </div>
                            </div>


                            <div class="form-group" v-if="showBannerImageUpload">
                                <label>IMAGE</label>
                                <input type="file"
                                       ref="image_src"
                                       name="image_src"
                                       multiple
                                       :class="[errors.image_src ? 'form-control is-invalid' : 'form-control']">

                                <div :class="[errors.image_src ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.image_src">{{ error }}</template>
                                </div>
                            </div>


                            <div class="form-group" v-if="!showBannerImageUpload">
                                <label>IMAGE</label><br>
                                <button @click="showBannerImageUpload = true" type="button" class="btn btn-primary btn-sm">{{ event.image_src }}</button>
                                <span class="small">Click to update</span>
                            </div>

                            <!--<div class="form-group">-->
                                <!--<label>AMOUNT <small class="text-info">Leave blank to set to default of 0.00 php</small></label>-->
                                <!--<input id="amount"-->
                                       <!--type="number"-->
                                       <!--name="amount"-->
                                       <!--v-model="form.amount"-->
                                       <!--:class="[errors.amount ? 'form-control is-invalid' : 'form-control']" />-->

                                <!--<div :class="[errors.amount ? 'invalid-feedback text-left' : '']">-->
                                    <!--<template v-for="error in errors.amount">{{ error }} <br></template>-->
                                <!--</div>-->
                            <!--</div>-->

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-darker text-white">
                            <h6 class="text-center text-white">CONTENT</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>HEADING</label>
                                <input id="header_text"
                                       type="text"
                                       name="header_text"
                                       v-model="form.header_text"
                                       :class="[errors.header_text ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.header_text ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.header_text">{{ error }} <br></template>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>CONTENT</label>
                                <textarea placeholder="Type in the contents of the event"
                                          v-model="form.text_content"
                                          cols="30"
                                          rows="6"
                                          :class="[errors.name ? 'form-control is-invalid' : 'form-control']"></textarea>

                                <div :class="[errors.text_content ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.text_content">{{ error }} <br></template>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>YOUTUBE URL</label>
                                <input id="video_url"
                                       type="text"
                                       name="video_url"
                                       v-model="form.video_url"
                                       :class="[errors.video_url ? 'form-control is-invalid' : 'form-control']" />

                                <div :class="[errors.video_url ? 'invalid-feedback text-left' : '']">
                                    <template v-for="error in errors.video_url">{{ error }} <br></template>
                                </div>
                            </div>

                            <slider-attachments v-if="showSliderImageUpload" v-model="slider_images"></slider-attachments>

                            <div class="form-group" v-if="!showSliderImageUpload">
                                <label>SLIDER IMAGES</label><br>
                                <button @click="showSliderImageUpload = true" type="button" class="btn btn-primary btn-sm text-left" v-html="filenames"></button>
                                <br><span class="small">Click to re-upload slider images</span>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button :disabled="disableUpdateButton" type="submit" class="btn btn-primary" v-html="updateButtonText"></button>
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
    import Wysiwyg from '../../components/Wysiwyg.vue';
    import SliderAttachments from '../../components/Event/Utils/SliderAttachments.vue';

    export default {
        components: {Wysiwyg, SliderAttachments},

        props: ['event'],

        data () {
            return {
                form: {
                    name: this.event.name,
                    description : this.event.description,
                    address: this.event.address,
                    image_src: this.event.image_src,
                    image_thumbnail_src: this.event.image_thumbnail_src,
                    amount: this.event.amount,
                    starting_at: this.event.starting_at,
                    ending_at: this.event.ending_at,
                    header_text: '',
                    text_content: '',
                    video_url: ''
                },

                slider_images: [],

                filenames: '',

                contents: collect(this.event.contents),

                users: null,

                errors : [],

                updateButtonText: 'Update',

                showBannerImageUpload: _.isNull(this.event.image_src) ? true : false,

                showSliderImageUpload: false,

                dateConfig: {
                    wrap: true, // set wrap to true only when using 'input-group'
                    altFormat: 'M j, Y G:i K',
                    altInput: true,
                    dateFormat: 'Y-m-d H:i:S',
                    enableTime: true
                }
            }
        },

        mounted() {
            this.buildContent();
        },

        watch: {
//            'form.user_id'(newValue) {
//                if (newValue != '') {
//                    this.errors = _.omit(this.errors, 'user_id');
//                }
//            },
//
//            'form.capacity'(newValue) {
//                if (newValue != '') {
//                    this.errors = _.omit(this.errors, 'capacity');
//                }
//            },
//
//            'form.signature'(newValue) {
//                if (newValue != '') {
//                    this.errors = _.omit(this.errors, 'signature');
//                }
//            }
        },

        computed: {
            disableUpdateButton() {
                if (this.updateButtonText == 'Update') {
                    return false;
                }

                return true;
            },
        },

        methods: {
            onUpdate() {
                this.updateButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                let params = new FormData();
                params.append('_method', 'PATCH');

                if (!_.isUndefined(this.$refs.image_src)) {
                    params.append('image_src', this.$refs.image_src.files[0]);
                }

                if (!_.isUndefined(this.$refs.image_thumbnail_src)) {
                    params.append('image_thumbnail_src', this.$refs.image_thumbnail_src.files[0]);
                }

                _.forEach(this.form, (item, index) => {
                    params.append(index, item);
                });

                _.forEach(this.slider_images, (item, index) => {
                    if (item != '') {
                        params.append('slider_images[' + index + ']', item);
                    }
                });

                axios.post(`/admin/events/${this.event.hash_id}/update`, params)
                    .then(({data}) => {
                        window.location.href = '/admin/events';
                    }).catch(error => {
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }

                        this.updateButtonText = 'Update';
                    });
            },

            buildContent() {
                if (this.contents.count() > 0) {
                    let header_text = this.contents.where('type', 'header_text').first();
                    if (!_.isUndefined(header_text)) {
                        if (!_.isNull(header_text)) {
                            this.form.header_text = header_text.header_text;
                        }
                    }

                    let text_content = this.contents.where('type', 'text_content').first();
                    if (!_.isUndefined(text_content)) {
                        if (!_.isNull(text_content)) {
                            this.form.text_content = text_content.text_content;
                        }
                    }

                    let video_url = this.contents.where('type', 'video_url').first();
                    if (!_.isUndefined(video_url)) {
                        if (!_.isNull(video_url)) {
                            this.form.video_url = video_url.video_url;
                        }
                    }

                    let slider_images = this.contents.where('type', 'slider_images').first();
                    if (!_.isUndefined(slider_images)) {
                        if (!_.isNull(slider_images)) {
                            this.showSliderImageUpload = false
                            this.filenames = collect(slider_images.slider_images).implode("<br>");
                        } else {
                            this.showSliderImageUpload = true
                        }
                    } else {
                        this.showSliderImageUpload = true
                    }
                } else {
                    this.showSliderImageUpload = true
                }
            }
        }
    }
</script>